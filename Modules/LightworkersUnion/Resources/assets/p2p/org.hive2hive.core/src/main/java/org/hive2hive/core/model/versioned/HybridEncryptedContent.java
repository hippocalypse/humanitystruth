package org.hive2hive.core.model.versioned;

import java.util.Arrays;

import org.hive2hive.core.TimeToLiveStore;

/**
 * This class contains the result of a hybrid encryption. It holds the RSA encrypted parameters and the AES
 * encrypted data.
 * 
 * @author Christian, Nico
 * 
 */
public final class HybridEncryptedContent extends BaseVersionedNetworkContent {

	private static final long serialVersionUID = -1612926603789157681L;

	private final byte[] encryptedParameters;
	private final byte[] encryptedData;
	private int timeToLive = TimeToLiveStore.convertDaysToSeconds(365);

	private String userId = null;
	private byte[] signature = null;

	public HybridEncryptedContent(byte[] encryptedParams, byte[] encryptedData) {
		this.encryptedParameters = encryptedParams;
		this.encryptedData = encryptedData;
	}

	/**
	 * Get the RSA encrypted parameters.
	 * 
	 * @return the encoded encrypted parameters
	 */
	public byte[] getEncryptedParameters() {
		return encryptedParameters;
	}

	/**
	 * Get the AES encrypted data.
	 * 
	 * @return the encoded encrypted data
	 */
	public byte[] getEncryptedData() {
		return encryptedData;
	}

	/**
	 * Set signature.
	 * 
	 * @param userId
	 *            the creator of the signature
	 * @param signature
	 *            the signature
	 */
	public void setSignature(String userId, byte[] signature) {
		this.userId = userId;
		this.signature = signature;
	}

	/**
	 * Getter
	 * 
	 * @return the creator of the signature
	 */
	public String getUserId() {
		return userId;
	}

	/**
	 * Getter
	 * 
	 * @return the signature of this message
	 */
	public byte[] getSignature() {
		return signature;
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
		return Arrays.hashCode(encryptedData);
	}
}
