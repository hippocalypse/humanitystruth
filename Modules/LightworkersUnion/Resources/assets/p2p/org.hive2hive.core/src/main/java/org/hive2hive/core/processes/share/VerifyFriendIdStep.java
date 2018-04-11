package org.hive2hive.core.processes.share;

import java.security.PublicKey;

import org.hive2hive.core.exceptions.GetFailedException;
import org.hive2hive.core.network.data.PublicKeyManager;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;

/**
 * A step which loads the public key of the friend. No result is a sign for a non-existing friend.
 * 
 * @author Nico, Seppi
 */
public class VerifyFriendIdStep extends ProcessStep<Void> {

	private final PublicKeyManager keyManager;
	private final String friendId;

	public VerifyFriendIdStep(PublicKeyManager keyManager, String friendId) {
		this.setName(getClass().getName());
		this.keyManager = keyManager;
		this.friendId = friendId;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
		try {
			// just get the public key. It does not produce any overhead since this call is cached or (if the
			// first time), the result will be cached, making the notification faster.
			PublicKey publicKey = keyManager.getPublicKey(friendId);
			if (publicKey == null) {
				throw new GetFailedException(String.format("The friend '%s' does not seem to exist.", friendId));
			}
		} catch (GetFailedException ex) {
			throw new ProcessExecutionException(this, ex, String.format("The friend '%s' does not seem to exist.", friendId));
		}
		
		return null;
	}

}