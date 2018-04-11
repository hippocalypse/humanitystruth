package org.hive2hive.core.processes.notify;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import net.tomp2p.dht.FutureGet;
import net.tomp2p.peers.PeerAddress;

import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.H2HTestData;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.parameters.Parameters;
import org.hive2hive.core.network.messages.direct.BaseDirectMessage;
import org.hive2hive.core.network.userprofiletask.TestUserProfileTask;
import org.hive2hive.core.network.userprofiletask.UserProfileTask;
import org.junit.Assert;

/**
 * Simple message factory for testing. It counts the received messages by checking whether the
 * {@link TestDirectNotificationMessage} has put the ordered content (indicating that it arrived)
 * 
 * @author Nico
 */
public class CountingNotificationMessageFactory extends BaseNotificationMessageFactory {

	private final NetworkManager sender;
	private final List<String> testContentKeys;
	private final H2HTestData data = new H2HTestData(H2HJUnitTest.randomString());

	public CountingNotificationMessageFactory(NetworkManager sender) {
		super(sender.getEncryption());
		this.sender = sender;
		testContentKeys = new ArrayList<String>();
	}

	public boolean allMsgsArrived() {
		return getSentMessageCount() == getArrivedMessageCount();
	}

	public int getSentMessageCount() {
		return testContentKeys.size();
	}

	public int getArrivedMessageCount() {
		int counter = 0;
		for (String contentKey : testContentKeys) {
			FutureGet futureGet = null;
			try {
				futureGet = sender.getDataManager().getUnblocked(
						new Parameters().setLocationKey(sender.getNodeId()).setContentKey(contentKey));
				futureGet.awaitUninterruptibly();
			} catch (NoPeerConnectionException e1) {
				Assert.fail();
			}

			if (futureGet.data() == null) {
				continue;
			}

			try {
				H2HTestData gotData = (H2HTestData) sender.getDataManager().getSerializer()
						.deserialize(futureGet.data().toBytes());
				if (gotData.getTestString().equalsIgnoreCase(data.getTestString())) {
					counter++;
				}
			} catch (ClassNotFoundException | IOException | NoPeerConnectionException e) {
				Assert.fail(e.getMessage());
			}
		}

		return counter;
	}

	@Override
	public BaseDirectMessage createPrivateNotificationMessage(PeerAddress receiver) {
		String contentKey = H2HJUnitTest.randomString();
		testContentKeys.add(contentKey);
		return new TestDirectNotificationMessage(receiver, sender.getNodeId(), contentKey, data);
	}

	@Override
	public UserProfileTask createUserProfileTask(String sender) {
		return new TestUserProfileTask(generateProtectionKeys());
	}

	@Override
	public BaseDirectMessage createHintNotificationMessage(PeerAddress receiver, String userId) {
		// trick a little bit: send the same message to other users. We are able to control the arrival.
		return createPrivateNotificationMessage(receiver);
	}

}
