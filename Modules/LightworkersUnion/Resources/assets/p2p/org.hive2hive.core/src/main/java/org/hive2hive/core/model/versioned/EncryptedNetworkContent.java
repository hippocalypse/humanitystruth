package org.hive2hive.core.model.versioned;

import java.util.Arrays;

import org.hive2hive.core.TimeToLiveStore;

/**
 * This class holds the bytes of an encrypted content and its initialization vector.
 * 
 * @author Christian
 */
public final class EncryptedNetworkContent extends BaseVersionedNetworkContent {

	// TODO maybe this class should not just represent symmetric encrypted content but also asymmetric

	private static final long serialVersionUID = -1330623025391853102L;
	private final byte[] cipherContent;
	private final byte[] initVector;
	private int timeToLive = TimeToLiveStore.convertDaysToSeconds(365);

	public EncryptedNetworkContent(byte[] cipherContent, byte[] initVector) {
		this.cipherContent = cipherContent;
		this.initVector = initVector;
	}

	public final byte[] getCipherContent() {
		return cipherContent;
	}

	public final byte[] getInitVector() {
		return initVector;
	}

	@Override
	public int getTimeToLive() {
		return timeToLive;
	}

	public void setTimeToLive(int timeToLive) {
		this.timeToLive = timeToLive;
	}

	@Override
	protected int getContentHash() {
		return Arrays.hashCode(cipherContent);
	}
}
