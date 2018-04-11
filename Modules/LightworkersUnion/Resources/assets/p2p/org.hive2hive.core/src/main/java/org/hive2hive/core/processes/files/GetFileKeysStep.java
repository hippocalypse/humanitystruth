package org.hive2hive.core.processes.files;

import java.io.File;

import org.hive2hive.core.H2HSession;
import org.hive2hive.core.exceptions.GetFailedException;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.model.versioned.UserProfile;
import org.hive2hive.core.processes.context.interfaces.IGetFileKeysContext;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Gets the file keys (and their protection keys).
 * 
 * @author Nico
 */
public class GetFileKeysStep extends ProcessStep<Void> {

	private static final Logger logger = LoggerFactory.getLogger(GetFileKeysStep.class);

	private final IGetFileKeysContext context;
	private final H2HSession session;

	public GetFileKeysStep(IGetFileKeysContext context, H2HSession session) {
		this.setName(getClass().getName());
		this.context = context;
		this.session = session;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
		File file = context.consumeFile();

		// file node can be null or already present
		logger.info("Getting the corresponding file node for file '{}'.", file.getName());

		// file node is null, first look it up in the user profile
		UserProfile profile = null;
		try {
			profile = session.getProfileManager().readUserProfile();
		} catch (GetFailedException e) {
			throw new ProcessExecutionException(this, e);
		}

		Index fileNode = profile.getFileByPath(file, session.getRootFile());
		if (fileNode == null) {
			throw new ProcessExecutionException(this, "File does not exist in user profile. Consider uploading a new file.");
		}

		// set the corresponding content protection keys
		context.provideChunkProtectionKeys(fileNode.getProtectionKeys());
		context.provideMetaFileEncryptionKeys(fileNode.getFileKeys());

		return null;
	}
}
