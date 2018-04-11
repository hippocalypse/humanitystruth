package org.hive2hive.core.utils;

import java.net.InetAddress;
import java.net.UnknownHostException;
import java.security.KeyPair;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.H2HSession;
import org.hive2hive.core.api.H2HNode;
import org.hive2hive.core.api.configs.NetworkConfiguration;
import org.hive2hive.core.api.interfaces.IFileConfiguration;
import org.hive2hive.core.api.interfaces.IH2HNode;
import org.hive2hive.core.api.interfaces.INetworkConfiguration;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.PublicKeyManager;
import org.hive2hive.core.network.data.UserProfileManager;
import org.hive2hive.core.network.data.download.DownloadManager;
import org.hive2hive.core.network.data.vdht.LocationsManager;
import org.hive2hive.core.processes.login.SessionParameters;
import org.hive2hive.core.security.H2HDummyEncryption;
import org.hive2hive.core.security.UserCredentials;
import org.hive2hive.core.serializer.FSTSerializer;
import org.hive2hive.core.utils.helper.TestFileAgent;

/**
 * Helper class for testing. Provides methods for creating, shutdown nodes and some random generators.
 * 
 * @author Seppi, Nico
 */
public class NetworkTestUtil {

	/**
	 * Creates a network with the given number of nodes. First node in the list is the
	 * initial node where all other nodes bootstrapped to him.</br>
	 * <b>Important:</b> After usage please shutdown the network. See {@link NetworkTestUtil#shutdownNetwork}
	 * 
	 * @param numberOfNodes
	 *            size of the network (has to be larger than one)
	 * @return list containing all nodes where the first one is the bootstrapping node (initial)
	 */
	public static List<NetworkManager> createNetwork(int numberOfNodes) {
		IFileConfiguration fileConfig = new TestFileConfiguration();
		List<NetworkManager> nodes = new ArrayList<NetworkManager>(numberOfNodes);

		// create the first node (initial)
		FSTSerializer serializer = new FSTSerializer();
		H2HDummyEncryption encryption = new H2HDummyEncryption();
		NetworkManager initial = new NetworkManager(encryption, serializer, fileConfig);
		INetworkConfiguration netConfig = NetworkConfiguration.createInitialLocalPeer("Node A");
		initial.connect(netConfig);
		nodes.add(initial);

		// create the other nodes and bootstrap them to the initial peer
		char letter = 'A';
		for (int i = 1; i < numberOfNodes; i++) {
			NetworkManager node = new NetworkManager(encryption, serializer, fileConfig);
			INetworkConfiguration otherNetConfig = NetworkConfiguration.createLocalPeer(String.format("Node %s", ++letter),
					initial.getConnection().getPeer().peer());
			node.connect(otherNetConfig);
			nodes.add(node);
		}

		return nodes;
	}

	/**
	 * Shutdown a network.
	 * 
	 * @param network
	 *            list containing all nodes which has to be disconnected.
	 */
	public static void shutdownNetwork(List<NetworkManager> network) {
		if (network != null) {
			for (NetworkManager networkManager : network) {
				networkManager.disconnect(false);
			}
		}
	}

	/**
	 * Generate and assign public/private key pairs to the nodes.
	 * 
	 * @param network
	 *            list containing all nodes which have different key pairs
	 * @throws NoPeerConnectionException
	 */
	public static void setDifferentSessions(List<NetworkManager> network) throws NoPeerConnectionException {
		for (NetworkManager node : network) {
			KeyPair keyPair = H2HJUnitTest.generateRSAKeyPair(H2HConstants.KEYLENGTH_USER_KEYS);
			KeyPair protectionKeyPair = H2HJUnitTest.generateRSAKeyPair(H2HConstants.KEYLENGTH_PROTECTION);
			UserCredentials userCredentials = H2HJUnitTest.generateRandomCredentials();

			UserProfileManager profileManager = new UserProfileManager(node.getDataManager(), userCredentials);
			PublicKeyManager keyManager = new PublicKeyManager(userCredentials.getUserId(), keyPair, protectionKeyPair,
					node.getDataManager());
			DownloadManager downloadManager = new DownloadManager(node, new TestFileConfiguration());
			LocationsManager locationsManager = new LocationsManager(node.getDataManager(), userCredentials.getUserId(),
					protectionKeyPair);

			SessionParameters params = new SessionParameters(new TestFileAgent());
			params.setDownloadManager(downloadManager);
			params.setKeyManager(keyManager);
			params.setUserProfileManager(profileManager);
			params.setLocationsManager(locationsManager);

			node.setSession(new H2HSession(params));
		}
	}

	/**
	 * Generate and assign a public/private key pair to all nodes.
	 * 
	 * @param network
	 *            list containing all nodes which need to have the same key pair
	 * @throws NoPeerConnectionException
	 */
	public static void setSameSession(List<NetworkManager> network) throws NoPeerConnectionException {
		KeyPair keyPair = H2HJUnitTest.generateRSAKeyPair(H2HConstants.KEYLENGTH_USER_KEYS);
		KeyPair protectionKeys = H2HJUnitTest.generateRSAKeyPair(H2HConstants.KEYLENGTH_USER_KEYS);
		UserCredentials userCredentials = H2HJUnitTest.generateRandomCredentials();
		for (NetworkManager node : network) {
			UserProfileManager profileManager = new UserProfileManager(node.getDataManager(), userCredentials);
			PublicKeyManager keyManager = new PublicKeyManager(userCredentials.getUserId(), keyPair, protectionKeys,
					node.getDataManager());
			DownloadManager downloadManager = new DownloadManager(node, new TestFileConfiguration());
			LocationsManager locationsManager = new LocationsManager(node.getDataManager(), userCredentials.getUserId(),
					protectionKeys);

			SessionParameters params = new SessionParameters(new TestFileAgent());
			params.setDownloadManager(downloadManager);
			params.setKeyManager(keyManager);
			params.setUserProfileManager(profileManager);
			params.setLocationsManager(locationsManager);

			node.setSession(new H2HSession(params));
		}
	}

	/**
	 * Creates a <code>Hive2Hive</code> network with the given number of nodes. First node in the list is the
	 * initial node where all other nodes bootstrapped to him.</br>
	 * <b>Important:</b> After usage please shutdown the network. See {@link NetworkTestUtil#shutdownNetwork}
	 * 
	 * @param numberOfNodes
	 *            size of the network (has to be larger than one)
	 * @return list containing all Hive2Hive nodes where the first one is the bootstrapping node (initial)
	 */
	public static List<IH2HNode> createH2HNetwork(int numberOfNodes) {
		if (numberOfNodes < 1)
			throw new IllegalArgumentException("Invalid network size.");
		List<IH2HNode> nodes = new ArrayList<IH2HNode>(numberOfNodes);

		// create initial peer
		FSTSerializer serializer = new FSTSerializer();
		H2HDummyEncryption encryption = new H2HDummyEncryption();
		IFileConfiguration fileConfig = new TestFileConfiguration();
		IH2HNode initial = H2HNode.createNode(fileConfig, encryption, serializer);
		initial.connect(NetworkConfiguration.createInitial("initial"));

		nodes.add(initial);

		try {
			InetAddress bootstrapAddress = InetAddress.getLocalHost();
			for (int i = 1; i < numberOfNodes; i++) {
				IH2HNode node = H2HNode.createNode(fileConfig, encryption, serializer);
				node.connect(NetworkConfiguration.create("node " + i, bootstrapAddress));
				nodes.add(node);
			}
		} catch (UnknownHostException e) {
			// should not happen
		}

		return nodes;
	}

	/**
	 * Shutdown a network.
	 * 
	 * @param network
	 *            list containing all nodes which has to be disconnected.
	 */
	public static void shutdownH2HNetwork(List<IH2HNode> network) {
		for (IH2HNode node : network) {
			node.disconnect();
		}
	}

	/**
	 * Selects a random node of the given network
	 * 
	 * @param network a list of online peers
	 * @return a random node in the list
	 */
	public static NetworkManager getRandomNode(List<NetworkManager> network) {
		return network.get(new Random().nextInt(network.size()));
	}
}
