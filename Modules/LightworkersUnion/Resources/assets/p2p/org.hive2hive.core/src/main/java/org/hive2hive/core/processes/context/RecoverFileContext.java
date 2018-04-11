package org.hive2hive.core.processes.context;

import java.io.File;
import java.security.KeyPair;

import org.hive2hive.core.model.versioned.BaseMetaFile;
import org.hive2hive.core.model.versioned.HybridEncryptedContent;
import org.hive2hive.core.processes.context.interfaces.IGetFileKeysContext;
import org.hive2hive.core.processes.context.interfaces.IGetMetaFileContext;

public class RecoverFileContext implements IGetFileKeysContext, IGetMetaFileContext {

	private final File file;
	private KeyPair metaFileEncryptionKeys;
	private BaseMetaFile metaFile;

	public RecoverFileContext(File file) {
		this.file = file;
	}

	@Override
	public File consumeFile() {
		return file;
	}

	@Override
	public void provideChunkProtectionKeys(KeyPair protectionKeys) {
		// not used here
	}

	@Override
	public void provideMetaFile(BaseMetaFile metaFile) {
		this.metaFile = metaFile;
	}

	public BaseMetaFile consumeMetaFile() {
		return metaFile;
	}

	@Override
	public void provideEncryptedMetaFile(HybridEncryptedContent encryptedMetaDocument) {
		// not used here
	}

	@Override
	public void provideMetaFileEncryptionKeys(KeyPair encryptionKeys) {
		this.metaFileEncryptionKeys = encryptionKeys;
	}

	@Override
	public KeyPair consumeMetaFileEncryptionKeys() {
		return metaFileEncryptionKeys;
	}
}
