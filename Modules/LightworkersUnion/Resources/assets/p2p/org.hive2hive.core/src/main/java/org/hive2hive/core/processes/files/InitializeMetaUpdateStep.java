package org.hive2hive.core.processes.files;

import java.util.List;

import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.FileIndex;
import org.hive2hive.core.model.FolderIndex;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.network.data.DataManager;
import org.hive2hive.core.processes.context.MetaDocumentPKUpdateContext;
import org.hive2hive.core.processes.context.interfaces.IInitializeMetaUpdateContext;
import org.hive2hive.core.processes.share.pkupdate.ChangeProtectionKeysStep;
import org.hive2hive.core.processes.share.pkupdate.InitializeChunkUpdateStep;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.composites.SyncProcess;
import org.hive2hive.processframework.decorators.AsyncComponent;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.hive2hive.processframework.interfaces.IProcessComponent;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Takes the shared folder and iteratively changes the protection keys of all meta files. Appends further
 * steps to change the content protection key of all contained chunks.
 * 
 * @author Nico, Seppi
 */
public class InitializeMetaUpdateStep extends ProcessStep<Void> {

	private static final Logger logger = LoggerFactory.getLogger(InitializeMetaUpdateStep.class);

	private final IInitializeMetaUpdateContext context;
	private final DataManager dataManager;

	public InitializeMetaUpdateStep(IInitializeMetaUpdateContext context, DataManager dataManager) {
		this.setName(getClass().getName());
		this.context = context;
		this.dataManager = dataManager;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
		if (context.isSharedBefore()) {
			logger.debug("No need to update any protection keys because the file / folder was already shared");
			return null;
		}

		Index index = context.consumeIndex();

		try {
			if (index.isFolder()) {
				FolderIndex folderIndex = (FolderIndex) index;
				initForFolder(folderIndex);
			} else {
				FileIndex fileIndex = (FileIndex) index;
				initForFile(fileIndex);
			}
		} catch (NoSessionException | NoPeerConnectionException ex) {
			throw new ProcessExecutionException(this, ex);
		}

		return null;
	}

	private void initForFolder(FolderIndex folderIndex) throws ProcessExecutionException, NoSessionException,
			NoPeerConnectionException {
		List<Index> indexList = Index.getIndexList(folderIndex);
		for (Index index : indexList) {
			if (index.isFile()) {
				initForFile((FileIndex) index);
			}
		}
	}

	private void initForFile(FileIndex fileIndex) throws NoSessionException, NoPeerConnectionException {
		logger.debug("Initialize to change the protection keys of meta document of index '{}'.", fileIndex.getName());
		// create the process and wrap it to make it asynchronous
		getParent().insertAfter(new AsyncComponent<>(buildProcess(fileIndex)), this);
	}

	private IProcessComponent<Void> buildProcess(FileIndex index) throws NoSessionException, NoPeerConnectionException {

		// create a new sub-process
		SyncProcess subProcess = new SyncProcess();

		// each meta document gets own context
		MetaDocumentPKUpdateContext metaContext = new MetaDocumentPKUpdateContext(context.consumeOldProtectionKeys(),
				context.consumeNewProtectionKeys(), index.getFilePublicKey(), index);

		subProcess.add(new GetMetaFileStep(metaContext, dataManager));
		subProcess.add(new ChangeProtectionKeysStep(metaContext, dataManager));
		subProcess.add(new InitializeChunkUpdateStep(metaContext, dataManager));

		return subProcess;
	}
}
