package org.hive2hive.core.processes.notify;

import java.security.PublicKey;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import org.hive2hive.core.exceptions.GetFailedException;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.network.data.PublicKeyManager;
import org.hive2hive.core.processes.context.NotifyProcessContext;
import org.hive2hive.processframework.ProcessStep;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Gets all public keys from these users iteratively
 * 
 * @author Nico
 * 
 */
// TODO get the keys in parallel
public class GetPublicKeysStep extends ProcessStep<Void> {

	private static final Logger logger = LoggerFactory.getLogger(GetPublicKeysStep.class);
	private final NotifyProcessContext context;
	private final PublicKeyManager keyManager;

	public GetPublicKeysStep(NotifyProcessContext context, PublicKeyManager keyManager) throws NoPeerConnectionException {
		this.setName(getClass().getName());
		this.context = context;
		this.keyManager = keyManager;
	}

	@Override
	protected Void doExecute() throws InvalidProcessStateException {
		Set<String> users = context.consumeUsersToNotify();

		logger.debug("Start getting public keys from {} user(s).", users.size());
		Map<String, PublicKey> keys = new HashMap<String, PublicKey>();

		for (String user : users) {
			try {
				PublicKey key = keyManager.getPublicKey(user);
				keys.put(user, key);
			} catch (GetFailedException e) {
				logger.error("Could not get the key for user {}", user);
			}
		}

		// store the keys to the context
		context.setUserPublicKeys(keys);
		
		return null;
	}
}
