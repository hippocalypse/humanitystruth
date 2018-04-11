package org.hive2hive.core.processes.logout;

import java.io.IOException;
import java.util.List;

import net.tomp2p.dht.FutureGet;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.versioned.Locations;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.parameters.Parameters;
import org.hive2hive.core.processes.ProcessFactory;
import org.hive2hive.core.security.UserCredentials;
import org.hive2hive.core.serializer.IH2HSerialize;
import org.hive2hive.core.utils.FileTestUtil;
import org.hive2hive.core.utils.NetworkTestUtil;
import org.hive2hive.core.utils.TestExecutionUtil;
import org.hive2hive.core.utils.UseCaseTestUtil;
import org.hive2hive.processframework.interfaces.IProcessComponent;
import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.BeforeClass;
import org.junit.Test;

/**
 * Tests the logout procedure.
 * 
 * @author Christian, Seppi
 */
public class LogoutTest extends H2HJUnitTest {

	private static List<NetworkManager> network;
	private static UserCredentials userCredentials;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = LogoutTest.class;
		beforeClass();

		network = NetworkTestUtil.createNetwork(DEFAULT_NETWORK_SIZE);
		userCredentials = generateRandomCredentials();

		UseCaseTestUtil.registerAndLogin(userCredentials, network.get(0), FileTestUtil.getTempDirectory());
	}

	@Test
	public void testLogout() throws ClassNotFoundException, IOException, NoSessionException, NoPeerConnectionException {
		NetworkManager client = network.get(0);
		IH2HSerialize serializer = client.getDataManager().getSerializer();

		// verify the locations map before logout
		FutureGet futureGet = client.getDataManager().getUnblocked(
				new Parameters().setLocationKey(userCredentials.getUserId()).setContentKey(H2HConstants.USER_LOCATIONS));
		futureGet.awaitUninterruptibly();
		futureGet.futureRequests().awaitUninterruptibly();
		Locations locations = (Locations) serializer.deserialize(futureGet.data().toBytes());

		Assert.assertEquals(1, locations.getPeerAddresses().size());

		// logout
		IProcessComponent<Void> process = ProcessFactory.instance().createLogoutProcess(client);
		TestExecutionUtil.executeProcessTillSucceded(process);

		// verify the locations map after logout
		FutureGet futureGet2 = client.getDataManager().getUnblocked(
				new Parameters().setLocationKey(userCredentials.getUserId()).setContentKey(H2HConstants.USER_LOCATIONS));
		futureGet2.awaitUninterruptibly();
		futureGet2.futureRequests().awaitUninterruptibly();
		Locations locations2 = (Locations) serializer.deserialize(futureGet2.data().toBytes());

		Assert.assertEquals(0, locations2.getPeerAddresses().size());
	}

	@AfterClass
	public static void endTest() {
		NetworkTestUtil.shutdownNetwork(network);
		afterClass();
	}
}
