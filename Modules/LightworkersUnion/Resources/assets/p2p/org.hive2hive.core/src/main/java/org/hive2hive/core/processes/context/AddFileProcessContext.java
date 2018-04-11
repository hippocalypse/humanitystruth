package org.hive2hive.core.processes.context;

import java.io.File;
import java.security.KeyPair;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;

import org.hive2hive.core.H2HSession;
import org.hive2hive.core.api.interfaces.IFileConfiguration;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.model.MetaChunk;
import org.hive2hive.core.model.versioned.BaseMetaFile;
import org.hive2hive.core.processes.context.interfaces.INotifyContext;
import org.hive2hive.core.processes.context.interfaces.IUploadContext;
import org.hive2hive.core.processes.files.add.AddNotificationMessageFactory;
import org.hive2hive.core.processes.notify.BaseNotificationMessageFactory;
import org.hive2hive.core.security.IH2HEncryption;

/**
 * The context for the process of putting a file.
 * 
 * @author Nico, Seppi
 */
public class AddFileProcessContext implements IUploadContext, INotifyContext {

	private final File file;
	private final H2HSession session;
	private final IFileConfiguration fileConfiguration;
	private final IH2HEncryption encryption;

	private List<MetaChunk> metaChunks = new ArrayList<MetaChunk>();

	private KeyPair chunkEncryptionKeys; // generated
	private KeyPair chunkProtectionKeys; // from parent FolderIndex
	private KeyPair fileKeys; // File Encryption Key Pair
	private KeyPair metaFileProtectionKeys;
	private boolean largeFile;
	private BaseMetaFile metaFile;
	private Index index;
	private Set<String> usersToNotify;
	private AddNotificationMessageFactory messageFactory;

	public AddFileProcessContext(File file, H2HSession session, IFileConfiguration fileConfiguration,
			IH2HEncryption encryption) {
		this.file = file;
		this.session = session;
		this.fileConfiguration = fileConfiguration;
		this.encryption = encryption;
	}

	@Override
	public File consumeFile() {
		return file;
	}

	@Override
	public void setLargeFile(boolean largeFile) {
		this.largeFile = largeFile;
	}

	@Override
	public IFileConfiguration consumeFileConfiguration() {
		return fileConfiguration;
	}

	@Override
	public File consumeRoot() {
		return session.getRootFile();
	}

	@Override
	public boolean isLargeFile() {
		return largeFile;
	}

	@Override
	public KeyPair consumeChunkProtectionKeys() {
		return chunkProtectionKeys;
	}

	@Override
	public void provideChunkProtectionKeys(KeyPair chunkProtectionKeys) {
		this.chunkProtectionKeys = chunkProtectionKeys;
	}

	@Override
	public KeyPair consumeChunkEncryptionKeys() {
		return chunkEncryptionKeys;
	}

	@Override
	public void provideChunkEncryptionKeys(KeyPair chunkEncryptionKeys) {
		this.chunkEncryptionKeys = chunkEncryptionKeys;
	}

	@Override
	public KeyPair consumeMetaFileEncryptionKeys() {
		return fileKeys;
	}

	public void provideFileKeys(KeyPair fileKeys) {
		this.fileKeys = fileKeys;
	}

	@Override
	public KeyPair consumeMetaFileProtectionKeys() {
		return metaFileProtectionKeys;
	}

	@Override
	public void provideMetaFileProtectionKeys(KeyPair metaFileProtectionKeys) {
		this.metaFileProtectionKeys = metaFileProtectionKeys;
	}

	@Override
	public List<MetaChunk> getMetaChunks() {
		return metaChunks;
	}

	public void provideMetaFile(BaseMetaFile metaFile) {
		this.metaFile = metaFile;
	}

	@Override
	public BaseMetaFile consumeMetaFile() {
		return metaFile;
	}

	@Override
	public void provideMetaFileHash(byte[] hash) {
		// not used so far
	}

	public void provideIndex(Index index) {
		this.index = index;
	}

	@Override
	public Index consumeIndex() {
		return index;
	}

	@Override
	public void provideUsersToNotify(Set<String> users) {
		this.usersToNotify = users;
	}

	public void provideMessageFactory(AddNotificationMessageFactory messageFactory) {
		this.messageFactory = messageFactory;
	}

	@Override
	public BaseNotificationMessageFactory consumeMessageFactory() {
		return messageFactory;
	}

	@Override
	public Set<String> consumeUsersToNotify() {
		return usersToNotify;
	}

	@Override
	public boolean allowLargeFile() {
		return true;
	}

	@Override
	public IH2HEncryption getEncryption() {
		return encryption;
	}

}
