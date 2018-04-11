package org.hive2hive.core.processes.files;

import java.io.File;
import java.math.BigInteger;

import org.hive2hive.core.api.interfaces.IFileConfiguration;
import org.hive2hive.core.exceptions.AbortModificationCode;
import org.hive2hive.core.exceptions.AbortModifyException;
import org.hive2hive.core.file.FileUtil;
import org.hive2hive.core.processes.context.interfaces.IUploadContext;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Validates whether the file exists and the file size is allowed
 * 
 * @author Nico, Seppi
 */
public class ValidateFileStep extends ProcessStep<Void> {

	private static final Logger logger = LoggerFactory.getLogger(ValidateFileStep.class);

	private final IUploadContext context;

	public ValidateFileStep(IUploadContext context) {
		this.setName(getClass().getName());
		this.context = context;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
		File file = context.consumeFile();
		if (!file.exists()) {
			throw new ProcessExecutionException(this, String.format("File does not exist: %s.", file));
		}

		if (file.isDirectory()) {
			logger.debug("File {} is a directory.", file.getName());
			return null;
		}

		// validate the file size
		IFileConfiguration config = context.consumeFileConfiguration();
		if (BigInteger.valueOf(FileUtil.getFileSize(file)).compareTo(config.getMaxFileSize()) == 1) {
			logger.debug("File {} is a 'large file'.", file.getName());
			if (!context.allowLargeFile()) {
				throw new ProcessExecutionException(this, new AbortModifyException(AbortModificationCode.LARGE_FILE_UPDATE, String.format("Large files are not allowed (%s).", file.getName())));
			
			}
			context.setLargeFile(true);
		} else {
			logger.debug("File {} is a 'small file'.", file.getName());
			context.setLargeFile(false);
		}
		return null;
	}
}
