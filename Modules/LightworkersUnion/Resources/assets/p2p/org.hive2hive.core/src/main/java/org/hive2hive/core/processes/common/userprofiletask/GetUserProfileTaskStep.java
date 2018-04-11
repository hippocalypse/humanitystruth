package org.hive2hive.core.processes.common.userprofiletask;

import java.io.IOException;
import java.security.GeneralSecurityException;
import java.security.PrivateKey;

import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.BaseNetworkContent;
import org.hive2hive.core.model.versioned.HybridEncryptedContent;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.DataManager;
import org.hive2hive.core.network.userprofiletask.UserProfileTask;
import org.hive2hive.core.processes.context.interfaces.IUserProfileTaskContext;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * A process step which gets the next {@link UserProfileTask} object of the currently logged in user.
 * 
 * @author Seppi, Nico
 */
public class GetUserProfileTaskStep extends ProcessStep<Void> {

	private static final Logger logger = LoggerFactory.getLogger(GetUserProfileTaskStep.class);

	private final IUserProfileTaskContext context;
	private String userId;

	private final NetworkManager networkManager;

	public GetUserProfileTaskStep(IUserProfileTaskContext context, NetworkManager networkManager) {
		this.setName(getClass().getName());
		this.networkManager = networkManager;
		if (context == null) {
			throw new IllegalArgumentException("Context can't be null.");
		}
		this.context = context;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException, ProcessExecutionException {
		userId = networkManager.getUserId();

		DataManager dataManager;
		try {
			dataManager = networkManager.getDataManager();
		} catch (NoPeerConnectionException ex) {
			throw new ProcessExecutionException(this, ex);
		}

		logger.debug("Get the next user profile task of user '{}'.", userId);
		BaseNetworkContent content = dataManager.getUserProfileTask(userId);

		if (content == null) {
			logger.warn("Did not get an user profile task. User ID = '{}'.", userId);
			context.provideUserProfileTask(null);
		} else {
			logger.debug("Got encrypted user profile task. User ID = '{}'", userId);

			HybridEncryptedContent encrypted = (HybridEncryptedContent) content;
			PrivateKey key = null;
			try {
				key = networkManager.getSession().getKeyPair().getPrivate();
			} catch (NoSessionException ex) {
				throw new ProcessExecutionException(this, ex);
			}
			BaseNetworkContent decrypted = null;
			try {
				decrypted = networkManager.getEncryption().decryptHybrid(encrypted, key);
			} catch (GeneralSecurityException | ClassNotFoundException | IOException ex) {
				throw new ProcessExecutionException(this, ex, "Could not decrypt user profile task.");
			}
			context.provideUserProfileTask((UserProfileTask) decrypted);
			setRequiresRollback(true);
			logger.debug("Successfully decrypted a user profile task. User ID = '{}'.", userId);
		}
		return null;
	}

	@Override
	protected Void doRollback() throws InvalidProcessStateException {
		context.provideUserProfileTask(null);
		setRequiresRollback(false);
		return null;
	}

}
