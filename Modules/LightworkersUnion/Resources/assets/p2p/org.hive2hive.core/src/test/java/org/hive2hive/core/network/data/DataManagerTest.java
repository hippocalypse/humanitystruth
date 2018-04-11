package org.hive2hive.core.network.data;

import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.KeyPair;
import java.security.SignatureException;
import java.util.List;

import net.tomp2p.peers.Number160;
import net.tomp2p.storage.Data;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.H2HTestData;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.DataManager.H2HPutStatus;
import org.hive2hive.core.network.data.parameters.Parameters;
import org.hive2hive.core.utils.NetworkTestUtil;
import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.BeforeClass;
import org.junit.Ignore;
import org.junit.Test;

/**
 * @author Seppi
 */
public class DataManagerTest extends H2HJUnitTest {

	private static List<NetworkManager> network;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = DataManagerTest.class;
		beforeClass();
		network = NetworkTestUtil.createNetwork(DEFAULT_NETWORK_SIZE);
	}

	@Test
	public void testPutGetRemove() throws Exception {
		String data = randomString();
		Parameters parameters = new Parameters().setLocationKey(randomString()).setContentKey(randomString())
				.setNetworkContent(new H2HTestData(data));

		Assert.assertEquals(H2HPutStatus.OK, NetworkTestUtil.getRandomNode(network).getDataManager().put(parameters));

		Assert.assertEquals(data,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters)).getTestString());

		Assert.assertTrue(NetworkTestUtil.getRandomNode(network).getDataManager().remove(parameters));

		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters));
	}

	@Test
	public void testPutGetRemoveOneLocationKeyMultipleContentKeys() throws Exception {
		String locationKey = randomString();

		// put three data objects
		String data1 = randomString();
		Parameters parameters1 = new Parameters().setLocationKey(locationKey).setContentKey(randomString())
				.setNetworkContent(new H2HTestData(data1));
		Assert.assertEquals(H2HPutStatus.OK, NetworkTestUtil.getRandomNode(network).getDataManager().put(parameters1));

		String data2 = randomString();
		Parameters parameters2 = new Parameters().setLocationKey(locationKey).setContentKey(randomString())
				.setNetworkContent(new H2HTestData(data2));
		Assert.assertEquals(H2HPutStatus.OK, NetworkTestUtil.getRandomNode(network).getDataManager().put(parameters2));

		String data3 = randomString();
		Parameters parameters3 = new Parameters().setLocationKey(locationKey).setContentKey(randomString())
				.setNetworkContent(new H2HTestData(data3));
		Assert.assertEquals(H2HPutStatus.OK, NetworkTestUtil.getRandomNode(network).getDataManager().put(parameters3));

		// get all three data objects
		Assert.assertEquals(data1,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters1)).getTestString());
		Assert.assertEquals(data2,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters2)).getTestString());
		Assert.assertEquals(data3,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters3)).getTestString());

		// remove first object
		Assert.assertTrue(NetworkTestUtil.getRandomNode(network).getDataManager().remove(parameters1));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters1));
		Assert.assertEquals(data2,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters2)).getTestString());
		Assert.assertEquals(data3,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters3)).getTestString());

		// remove 2nd object
		Assert.assertTrue(NetworkTestUtil.getRandomNode(network).getDataManager().remove(parameters2));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters1));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters2));
		Assert.assertEquals(data3,
				((H2HTestData) NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters3)).getTestString());

		// remove 3rd object
		Assert.assertTrue(NetworkTestUtil.getRandomNode(network).getDataManager().remove(parameters3));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters1));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters2));
		Assert.assertNull(NetworkTestUtil.getRandomNode(network).getDataManager().get(parameters3));
	}

	@Test
	public void testChangeProtectionKeySingleVersionKey() throws NoPeerConnectionException, IOException,
			InvalidKeyException, SignatureException {
		KeyPair keypairOld = generateRSAKeyPair(H2HConstants.KEYLENGTH_PROTECTION);
		KeyPair keypairNew = generateRSAKeyPair(H2HConstants.KEYLENGTH_PROTECTION);

		H2HTestData data = new H2HTestData(randomString());
		data.generateVersionKey();
		data.setBasedOnKey(Number160.ZERO);
		Parameters parameters = new Parameters().setLocationKey(randomString()).setContentKey(randomString())
				.setVersionKey(data.getVersionKey()).setNetworkContent(data).setProtectionKeys(keypairOld)
				.setNewProtectionKeys(keypairNew).setTTL(data.getTimeToLive()).setHashFlag(true);

		NetworkManager node = NetworkTestUtil.getRandomNode(network);

		// put some initial data
		Assert.assertEquals(H2HPutStatus.OK, node.getDataManager().put(parameters));

		// parameters without the data object itself
		parameters = new Parameters().setLocationKey(parameters.getLocationKey()).setContentKey(parameters.getContentKey())
				.setVersionKey(data.getVersionKey()).setProtectionKeys(keypairOld).setNewProtectionKeys(keypairNew)
				.setTTL(data.getTimeToLive());

		// change content protection key
		Assert.assertTrue(node.getDataManager().changeProtectionKey(parameters));

		// verify if content protection key has been changed
		Data resData = node.getDataManager().getUnblocked(parameters).awaitUninterruptibly().data();
		Assert.assertEquals(keypairNew.getPublic(), resData.publicKey());
	}

	@Test
	@Ignore
	public void testChangeProtectionKeyMultipleVersionKeys() throws NoPeerConnectionException, IOException,
			InvalidKeyException, SignatureException {
		// TODO test case for changing entries wit same location, domain and content key, but different
		// version keys
	}

	@AfterClass
	public static void cleanAfterClass() {
		NetworkTestUtil.shutdownNetwork(network);
		afterClass();
	}
}
