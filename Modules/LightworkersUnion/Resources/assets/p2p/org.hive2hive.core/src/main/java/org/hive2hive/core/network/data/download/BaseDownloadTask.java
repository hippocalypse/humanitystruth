package org.hive2hive.core.network.data.download;

import java.io.File;
import java.io.IOException;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.UUID;
import java.util.concurrent.CountDownLatch;
import java.util.concurrent.atomic.AtomicBoolean;

import org.apache.commons.io.FileUtils;
import org.hive2hive.core.events.EventBus;
import org.hive2hive.core.events.framework.interfaces.IFileEventGenerator;
import org.hive2hive.core.file.FileChunkUtil;
import org.hive2hive.core.model.MetaChunk;
import org.hive2hive.core.network.data.PublicKeyManager;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.hive2hive.processframework.interfaces.IProcessComponent;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public abstract class BaseDownloadTask implements Serializable, IFileEventGenerator {

	private static final long serialVersionUID = 1580305288943800375L;
	private static final Logger logger = LoggerFactory.getLogger(BaseDownloadTask.class);

	private final List<MetaChunk> metaChunks;
	private final File destination;
	private final File tempFolder;
	private final PublicKeyManager keyManager;
	protected final EventBus eventBus;

	private final File[] downloadedChunks;
	// when the download has finished
	private final CountDownLatch finishedLatch;
	private final Set<IDownloadListener> listeners;

	private final AtomicBoolean aborted;
	private String reason;

	public BaseDownloadTask(List<MetaChunk> metaChunks, File destination, EventBus eventBus, PublicKeyManager keyManager) {
		this.metaChunks = metaChunks;
		this.destination = destination;
		this.keyManager = keyManager;
		this.finishedLatch = new CountDownLatch(1);
		this.listeners = new HashSet<IDownloadListener>();
		this.aborted = new AtomicBoolean(false);
		this.eventBus = eventBus;

		// init array as null
		this.downloadedChunks = new File[metaChunks.size()];
		for (int i = 0; i < downloadedChunks.length; i++) {
			downloadedChunks[i] = null;
		}

		// create the download folder
		String folderName = destination.getName() + "-" + UUID.randomUUID().toString();
		tempFolder = new File(FileUtils.getTempDirectory(), folderName);
		if (!tempFolder.mkdirs()) {
			logger.warn("Cannot create temporary download folder {}", tempFolder.getAbsolutePath());
		}
	}

	/**
	 * Returns a list of chunks that are not downloaded yed
	 * 
	 * @return a list of chunks which still need to be downloaded
	 */
	public List<MetaChunk> getOpenChunks() {
		List<MetaChunk> openChunks = new ArrayList<MetaChunk>();
		for (MetaChunk metaChunk : metaChunks) {
			if (downloadedChunks[metaChunk.getIndex()] == null || !downloadedChunks[metaChunk.getIndex()].exists()) {
				openChunks.add(metaChunk);
			}
		}

		return openChunks;
	}

	public File getDestination() {
		return destination;
	}

	public String getDestinationName() {
		return destination.getName();
	}

	public abstract boolean isDirectDownload();

	public File getTempDirectory() {
		return tempFolder;
	}

	public void abortDownload(String reason) {
		if (aborted.get()) {
			// already aborted
			return;
		} else {
			aborted.set(true);
		}

		logger.error("Download of file {} aborted. Reason: {}", getDestinationName(), reason);
		this.reason = reason;

		// notify listeners
		for (IDownloadListener listener : listeners) {
			listener.downloadFailed(this, reason);
		}

		// immediately count down the latch
		finishedLatch.countDown();
	}

	public boolean isAborted() {
		return aborted.get();
	}

	private boolean isDone() {
		for (int i = 0; i < downloadedChunks.length; i++) {
			if (downloadedChunks[i] == null) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Mark the given chunk as downloaded
	 * 
	 * @param chunkIndex the index of the chunk (unique number)
	 * @param filePart the file holding the content of the chunk
	 */
	public synchronized void markDownloaded(int chunkIndex, File filePart) {
		logger.debug("Successfully downloaded chunk {} of file {}", chunkIndex, getDestinationName());
		downloadedChunks[chunkIndex] = filePart;

		if (isAborted()) {
			// no need for further processing
			return;
		} else if (finishedLatch.getCount() == 0) {
			// already done with the download
			return;
		}

		int openChunkNumber = getOpenChunks().size();
		if (openChunkNumber > 0) {
			logger.debug("{} chunks of file {} are still downloading.", openChunkNumber, getDestinationName());
		} else {
			logger.debug("All parts of file {} are downloaded, reassembling them...", getDestinationName());
			try {
				// reassembly
				List<File> fileParts = Arrays.asList(downloadedChunks);
				FileChunkUtil.reassembly(fileParts, destination);
				logger.debug("File {} has successfully been reassembled", getDestinationName());

				// notify listeners
				for (IDownloadListener listener : listeners) {
					listener.downloadFinished(this);
				}

				// delete the temporary download folder
				if (!tempFolder.delete()) {
					logger.warn("Couldn't delete temporary download folder '{}'.", tempFolder);
				}

				// release the lock
				finishedLatch.countDown();
			} catch (IOException e) {
				abortDownload(String.format("Cannot reassembly the file parts. Reason: %s.", reason + e.getMessage()));
			}
		}
	}

	public void addListener(IDownloadListener listener) {
		listeners.add(listener);
	}

	/**
	 * Join the download process
	 * 
	 * @throws ProcessExecutionException if there was an error while downloading
	 * @throws InterruptedException if the process was interrupted or was unable to wait
	 */
	public void join(IProcessComponent<?> process) throws ProcessExecutionException, InterruptedException {
		finishedLatch.await();

		if (isAborted()) {
			throw new ProcessExecutionException(process, String.format("Aborted. Reason: %s.", reason));
		} else if (!isDone()) {
			throw new InterruptedException("Could not wait until all downloads are done");
		}
	}

	public PublicKeyManager getKeyManager() {
		return keyManager;
	}
}
