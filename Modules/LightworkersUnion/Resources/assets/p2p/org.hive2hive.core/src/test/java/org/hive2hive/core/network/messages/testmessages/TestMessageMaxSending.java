package org.hive2hive.core.network.messages.testmessages;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HTestData;
import org.hive2hive.core.network.messages.AcceptanceReply;
import org.hive2hive.core.network.messages.BaseMessageTest;

/**
 * Test message to simulate rejecting receiver nodes. For further details see
 * {@link BaseMessageTest#testSendingAnAsynchronousMessageWithNoReplyMaxTimesTargetNode()}
 * 
 * @author Seppi
 */
public class TestMessageMaxSending extends TestMessage {

	private static final long serialVersionUID = -6955621718515026298L;
	private static int numFails;

	public TestMessageMaxSending(String targetKey, String contentKey, H2HTestData wrapper) {
		super(targetKey, contentKey, wrapper);
		numFails = 0;
	}

	@Override
	public AcceptanceReply accept() {
		// reject all messages till last try
		if (++numFails < H2HConstants.MAX_MESSAGE_SENDING) {
			return AcceptanceReply.FAILURE;
		}
		return AcceptanceReply.OK;
	}

}
