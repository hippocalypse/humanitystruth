package org.hive2hive.core.processes.notify;

import java.security.KeyPair;

import net.tomp2p.peers.PeerAddress;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.network.messages.direct.BaseDirectMessage;
import org.hive2hive.core.network.userprofiletask.UserProfileTask;
import org.hive2hive.core.security.IH2HEncryption;

/**
 * Abstract class needed by the notification process to generate notification messages. It generates
 * notification messages for the own user, UserProfileTasks for other users and a notification message to
 * tickle one client of the other users to process their UP tasks.
 * 
 * @author Nico
 * 
 */
public abstract class BaseNotificationMessageFactory {

	private final IH2HEncryption encryption;

	public BaseNotificationMessageFactory(IH2HEncryption encryption) {
		this.encryption = encryption;
	}

	/**
	 * Generates the protection keys for the user profile task. This is just a convenience method
	 */
	protected KeyPair generateProtectionKeys() {
		return encryption.generateRSAKeyPair(H2HConstants.KEYLENGTH_PROTECTION);
	}

	/**
	 * Create a private message to notify clients of the same user.
	 * 
	 * @param receiver
	 * @return the message for notifying own clients
	 */
	public abstract BaseDirectMessage createPrivateNotificationMessage(PeerAddress receiver);

	/**
	 * Create a user profile task to put it into the queue of other users.
	 * 
	 * @return the user profile task or <code>null</code> if none is required
	 */
	public abstract UserProfileTask createUserProfileTask(String sender);

	/**
	 * After putting the {@link UserProfileTask} in the queue of the other users, notify them with this
	 * message
	 * 
	 * @param receiver
	 * @param userId
	 * @return the message to other users clients (master node)
	 */
	public BaseDirectMessage createHintNotificationMessage(PeerAddress receiver, String userId) {
		return new UserProfileTaskNotificationMessage(receiver, userId);
	}
}
