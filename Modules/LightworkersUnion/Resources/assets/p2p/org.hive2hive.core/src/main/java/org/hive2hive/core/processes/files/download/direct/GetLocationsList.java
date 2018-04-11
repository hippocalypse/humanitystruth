package org.hive2hive.core.processes.files.download.direct;

import java.util.Collections;
import java.util.HashSet;
import java.util.Set;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.model.BaseNetworkContent;
import org.hive2hive.core.model.versioned.Locations;
import org.hive2hive.core.network.data.DataManager;
import org.hive2hive.core.processes.common.base.BaseGetProcessStep;
import org.hive2hive.processframework.composites.SyncProcess;
import org.hive2hive.processframework.decorators.AsyncComponent;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Gets a list of all locations (using the internal process framework
 * 
 * @author Nico, Seppi
 */
public class GetLocationsList implements Runnable {

	private static final Logger logger = LoggerFactory.getLogger(GetLocationsList.class);

	private final DownloadTaskDirect task;
	private final DataManager dataManager;

	public GetLocationsList(DownloadTaskDirect task, DataManager dataManager) {
		this.task = task;
		this.dataManager = dataManager;
	}

	@Override
	public void run() {
		// thread safe super collection
		final Set<Locations> collectingSet = Collections.synchronizedSet(new HashSet<Locations>());

		SyncProcess process = new SyncProcess();
		for (final String userId : task.getUsers()) {
			process.add(new AsyncComponent<>(new BaseGetProcessStep(dataManager) {
				@Override
				protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
					BaseNetworkContent content = get(userId, H2HConstants.USER_LOCATIONS);
					if (content != null) {
						synchronized (collectingSet) {
							collectingSet.add((Locations) content);
						}
					}
					return null;
				}
			}));
		}

		try {
			logger.debug("Started getting the list of locations to download {}", task.getDestinationName());
			process.execute();
		} catch (InvalidProcessStateException | ProcessExecutionException ex) {
			task.provideLocations(new HashSet<Locations>());
			task.abortDownload(ex.getMessage());
			return;
		}

		if (logger.isDebugEnabled()) {
			int numPeerAddresses = 0;
			for (Locations locations : collectingSet) {
				numPeerAddresses += locations.getPeerAddresses().size();
			}
			logger.debug("Got {} candidate location(s) with {} peer address(es) to download {}", collectingSet.size(),
					numPeerAddresses, task.getDestinationName());
		}

		task.provideLocations(collectingSet);
	}

}
