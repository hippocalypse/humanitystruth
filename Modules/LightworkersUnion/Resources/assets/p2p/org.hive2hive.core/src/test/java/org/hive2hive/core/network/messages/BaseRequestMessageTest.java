package org.hive2hive.core.network.messages;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertTrue;

import java.io.IOException;
import java.security.PublicKey;
import java.util.List;

import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.H2HTestData;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.BaseNetworkContent;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.parameters.Parameters;
import org.hive2hive.core.network.messages.direct.response.IResponseCallBackHandler;
import org.hive2hive.core.network.messages.direct.response.ResponseMessage;
import org.hive2hive.core.network.messages.request.IRequestMessage;
import org.hive2hive.core.network.messages.testmessages.TestMessageWithReply;
import org.hive2hive.core.network.messages.testmessages.TestMessageWithReply.TestCallBackHandler;
import org.hive2hive.core.network.messages.testmessages.TestMessageWithReplyMaxSending;
import org.hive2hive.core.network.messages.testmessages.TestMessageWithReplyMaxSending.TestCallBackHandlerMaxSendig;
import org.hive2hive.core.utils.H2HWaiter;
import org.hive2hive.core.utils.NetworkTestUtil;
import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;

/**
 * Tests asynchronous request messages where the receiver node has to respond with a response message which
 * gets handled by a callback handler.
 * 
 * @author Seppi
 */
public class BaseRequestMessageTest extends H2HJUnitTest {

	private static List<NetworkManager> network;
	private static final int networkSize = 2;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = BaseRequestMessageTest.class;
		beforeClass();
		network = NetworkTestUtil.createNetwork(networkSize);
		NetworkTestUtil.setSameSession(network);
	}

	/**
	 * Test if a asynchronous message (implementing the {@link IRequestMessage}) interface gets
	 * properly handled. To verify this node A sends to node B a randomly created contentKey. Node B generates
	 * a random secret. The secret gets locally stored (location key is node B's node id) and sent back
	 * with a {@link ResponseMessage} to node A. A callback handler implementing
	 * {@link IResponseCallBackHandler} at
	 * node A handles the received response message and also locally puts the received secret into the DHT
	 * (location key is node A's node id). Every think went right when under both location keys the same data
	 * appears.
	 * 
	 * @throws IOException
	 * @throws ClassNotFoundException
	 * @throws NoPeerConnectionException
	 * @throws NoSessionException
	 */
	@Test
	public void testSendingAnAsynchronousMessageWithReply() throws ClassNotFoundException, IOException,
			NoPeerConnectionException, NoSessionException {
		NetworkManager nodeA = network.get(0);
		NetworkManager nodeB = network.get(1);

		// receiver nodes should already know the public key of the senders
		nodeA.getSession().getKeyManager().putPublicKey(nodeB.getUserId(), getPublicKey(nodeB));
		nodeB.getSession().getKeyManager().putPublicKey(nodeA.getUserId(), getPublicKey(nodeA));

		// generate a random content key
		String contentKey = randomString();
		// create a message with target node B
		TestMessageWithReply message = new TestMessageWithReply(nodeB.getNodeId(), contentKey);
		// create and add a callback handler
		TestCallBackHandler callBackHandler = message.new TestCallBackHandler(nodeA);
		message.setCallBackHandler(callBackHandler);

		// send message
		assertTrue(nodeA.getMessageManager().send(message, getPublicKey(nodeB)));

		// wait till callback handler gets executed
		H2HWaiter w = new H2HWaiter(10);
		BaseNetworkContent content = null;
		do {
			w.tickASecond();
			content = nodeB.getDataManager().get(
					new Parameters().setLocationKey(nodeA.getNodeId()).setContentKey(contentKey));
		} while (content == null);

		// load and verify if same secret was shared
		String receivedSecret = ((H2HTestData) content).getTestString();
		String originalSecret = ((H2HTestData) nodeB.getDataManager().get(
				new Parameters().setLocationKey(nodeB.getNodeId()).setContentKey(contentKey))).getTestString();
		assertEquals(originalSecret, receivedSecret);
	}

	/**
	 * This tests sends a message with a request asynchronously to the target node. The response message (sent
	 * from the responding node) is configured in a way that it will be blocked on the target node (requesting
	 * node) till the maximum allowed numbers of retrying to send the very message is reached.
	 * 
	 * @throws IOException
	 * @throws ClassNotFoundException
	 * @throws NoPeerConnectionException
	 * @throws NoSessionException
	 */
	@Test
	public void testSendingAnAsynchronousMessageWithNoReplyMaxTimesRequestingNode() throws ClassNotFoundException,
			IOException, NoPeerConnectionException, NoSessionException {
		NetworkManager nodeA = network.get(0);
		NetworkManager nodeB = network.get(1);

		// receiver nodes should already know the public key of the senders
		nodeA.getSession().getKeyManager().putPublicKey(nodeB.getUserId(), getPublicKey(nodeB));
		nodeB.getSession().getKeyManager().putPublicKey(nodeA.getUserId(), getPublicKey(nodeA));

		// generate a random content key
		String contentKey = randomString();
		// create a message with target node B
		TestMessageWithReplyMaxSending message = new TestMessageWithReplyMaxSending(nodeB.getNodeId(), contentKey);
		// create and add a callback handler
		TestCallBackHandlerMaxSendig callBackHandler = message.new TestCallBackHandlerMaxSendig(nodeA);
		message.setCallBackHandler(callBackHandler);

		// send message
		assertTrue(nodeA.getMessageManager().send(message, getPublicKey(nodeB)));

		// wait till callback handler gets executed
		H2HWaiter w = new H2HWaiter(10);
		BaseNetworkContent content = null;
		do {
			w.tickASecond();
			content = nodeB.getDataManager().get(
					new Parameters().setLocationKey(nodeA.getNodeId()).setContentKey(contentKey));
		} while (content == null);

		// load and verify if same secret was shared
		String receivedSecret = ((H2HTestData) content).getTestString();
		String originalSecret = ((H2HTestData) nodeB.getDataManager().get(
				new Parameters().setLocationKey(nodeB.getNodeId()).setContentKey(contentKey))).getTestString();
		assertEquals(originalSecret, receivedSecret);
	}

	private PublicKey getPublicKey(NetworkManager networkManager) {
		try {
			return networkManager.getSession().getKeyPair().getPublic();
		} catch (NoSessionException e) {
			return null;
		}
	}

	@AfterClass
	public static void endTest() {
		NetworkTestUtil.shutdownNetwork(network);
		afterClass();
	}

}
