package org.hive2hive.core.processes.context;

import java.security.KeyPair;
import java.security.PublicKey;

import net.tomp2p.peers.Number160;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.TimeToLiveStore;
import org.hive2hive.core.model.FileIndex;
import org.hive2hive.core.model.versioned.BaseMetaFile;
import org.hive2hive.core.model.versioned.HybridEncryptedContent;
import org.hive2hive.core.processes.context.interfaces.IGetMetaFileContext;
import org.hive2hive.core.security.H2HDefaultEncryption;

/**
 * Provides the required context to update the meta document
 * 
 * @author Nico, Seppi
 */
public class MetaDocumentPKUpdateContext extends BasePKUpdateContext implements IGetMetaFileContext {

	private final PublicKey fileKey;
	private final FileIndex fileIndex;
	private BaseMetaFile metaFile;

	public MetaDocumentPKUpdateContext(KeyPair oldProtectionKeys, KeyPair newProtectionKeys, PublicKey fileKey,
			FileIndex fileIndex) {
		super(oldProtectionKeys, newProtectionKeys);
		this.fileKey = fileKey;
		this.fileIndex = fileIndex;
	}

	@Override
	public void provideMetaFile(BaseMetaFile metaFile) {
		this.metaFile = metaFile;
	}

	@Override
	public void provideEncryptedMetaFile(HybridEncryptedContent encryptedMetaDocument) {
		// ignore
	}

	public BaseMetaFile consumeMetaFile() {
		return metaFile;
	}

	@Override
	public String getLocationKey() {
		return H2HDefaultEncryption.key2String(fileKey);
	}

	@Override
	public String getContentKey() {
		return H2HConstants.META_FILE;
	}

	@Override
	public int getTTL() {
		return TimeToLiveStore.getInstance().getMetaFile();
	}

	@Override
	public byte[] getHash() {
		return fileIndex.getMetaFileHash();
	}

	@Override
	public Number160 getVersionKey() {
		return metaFile.getVersionKey();
	}

	public String getFileName() {
		return fileIndex.getName();
	}

	@Override
	public KeyPair consumeMetaFileEncryptionKeys() {
		return fileIndex.getFileKeys();
	}

}