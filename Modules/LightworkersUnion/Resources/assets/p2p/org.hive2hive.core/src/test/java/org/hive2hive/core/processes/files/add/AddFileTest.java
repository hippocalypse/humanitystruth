package org.hive2hive.core.processes.files.add;

import java.io.File;
import java.io.IOException;
import java.security.KeyPair;
import java.util.List;

import org.apache.commons.io.FileUtils;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.exceptions.GetFailedException;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.model.versioned.BaseMetaFile;
import org.hive2hive.core.model.versioned.MetaFileSmall;
import org.hive2hive.core.model.versioned.UserProfile;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.processes.ProcessFactory;
import org.hive2hive.core.security.UserCredentials;
import org.hive2hive.core.utils.FileTestUtil;
import org.hive2hive.core.utils.NetworkTestUtil;
import org.hive2hive.core.utils.TestFileConfiguration;
import org.hive2hive.core.utils.UseCaseTestUtil;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.hive2hive.processframework.interfaces.IProcessComponent;
import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.BeforeClass;
import org.junit.Test;

/**
 * Tests uploading a new file.
 * 
 * @author Nico, Seppi
 */
public class AddFileTest extends H2HJUnitTest {

	private final static int NETWORK_SIZE = 5;

	private static List<NetworkManager> network;
	private static UserCredentials userCredentials;
	private static File uploaderRoot;
	private static File downloaderRoot;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = AddFileTest.class;
		beforeClass();
		// setup network
		network = NetworkTestUtil.createNetwork(NETWORK_SIZE);
		// create some random user credentials
		userCredentials = generateRandomCredentials();
		// register and login a user (peer 0)
		uploaderRoot = FileTestUtil.getTempDirectory();
		UseCaseTestUtil.registerAndLogin(userCredentials, network.get(0), uploaderRoot);

		// other client to verify this
		downloaderRoot = FileTestUtil.getTempDirectory();
		UseCaseTestUtil.login(userCredentials, network.get(1), downloaderRoot);
	}

	@Test
	public void testUploadSingleChunk() throws IOException, IllegalArgumentException, NoSessionException,
			GetFailedException, NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		File file = FileTestUtil.createFileRandomContent(1, uploaderRoot);

		UseCaseTestUtil.uploadNewFile(network.get(0), file);
		verifyUpload(file, 1);
	}

	@Test
	public void testUploadMultipleChunks() throws IOException, IllegalArgumentException, NoSessionException,
			GetFailedException, NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		// creates a file with length of at least 5 chunks
		File file = FileTestUtil.createFileRandomContent(5, uploaderRoot);

		UseCaseTestUtil.uploadNewFile(network.get(0), file);
		verifyUpload(file, 5);
	}

	@Test
	public void testUploadFolder() throws IOException, IllegalArgumentException, NoSessionException, GetFailedException,
			NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		File folder = new File(uploaderRoot, "folder1");
		folder.mkdirs();

		UseCaseTestUtil.uploadNewFile(network.get(0), folder);
		verifyUpload(folder, 0);
	}

	@Test
	public void testUploadFolderWithFile() throws IOException, IllegalArgumentException, NoSessionException,
			GetFailedException, NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		// create a container
		File folder = new File(uploaderRoot, "folder-with-file");
		folder.mkdirs();
		UseCaseTestUtil.uploadNewFile(network.get(0), folder);

		File file = new File(folder, "test-file");
		FileUtils.writeStringToFile(file, randomString());
		UseCaseTestUtil.uploadNewFile(network.get(0), file);
		verifyUpload(file, 1);
	}

	@Test
	public void testUploadFolderWithFolder() throws IOException, IllegalArgumentException, NoSessionException,
			GetFailedException, NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		File folder = new File(uploaderRoot, "folder-with-folder");
		folder.mkdirs();
		UseCaseTestUtil.uploadNewFile(network.get(0), folder);

		File innerFolder = new File(uploaderRoot, "inner-folder");
		innerFolder.mkdir();
		UseCaseTestUtil.uploadNewFile(network.get(0), innerFolder);

		verifyUpload(innerFolder, 0);
	}

	@Test(expected = NoSessionException.class)
	public void testUploadNoSession() throws IOException, IllegalArgumentException, NoSessionException,
			InvalidProcessStateException, NoPeerConnectionException, ProcessExecutionException {
		// skip the login and continue with the newfile process
		NetworkManager client = network.get(2);

		File file = FileTestUtil.createFileRandomContent(1, uploaderRoot);
		IProcessComponent<Void> process = ProcessFactory.instance().createAddFileProcess(file, client,
				new TestFileConfiguration());
		process.execute();
	}

	@Test(expected = IllegalArgumentException.class)
	public void testUploadNull() throws NoSessionException, NoPeerConnectionException {
		ProcessFactory.instance().createAddFileProcess(null, network.get(0), new TestFileConfiguration());
	}

	private void verifyUpload(File originalFile, int expectedChunks) throws IOException, GetFailedException,
			NoSessionException, NoPeerConnectionException, InvalidProcessStateException, ProcessExecutionException {
		// pick new client to test
		NetworkManager client = network.get(1);

		// test if there is something in the user profile
		UserProfile gotProfile = UseCaseTestUtil.getUserProfile(client, userCredentials);
		Assert.assertNotNull(gotProfile);

		Index node = gotProfile.getFileByPath(originalFile, uploaderRoot);
		Assert.assertNotNull(node);

		// verify the meta document
		KeyPair metaFileKeys = node.getFileKeys();
		if (originalFile.isFile()) {
			BaseMetaFile metaFile = UseCaseTestUtil.getMetaFile(client, metaFileKeys);
			Assert.assertNotNull(metaFile);
			Assert.assertTrue(metaFile instanceof MetaFileSmall);
			MetaFileSmall metaFileSmall = (MetaFileSmall) metaFile;

			// get the meta file with the keys (decrypt it)
			Assert.assertEquals(1, metaFileSmall.getVersions().size());
			Assert.assertEquals(expectedChunks, metaFileSmall.getVersions().get(0).getMetaChunks().size());
		}
	}

	@AfterClass
	public static void endTest() throws IOException {
		NetworkTestUtil.shutdownNetwork(network);
		if (uploaderRoot != null && uploaderRoot.exists()) {
			FileUtils.deleteDirectory(uploaderRoot);
		}
		if (downloaderRoot != null && downloaderRoot.exists()) {
			FileUtils.deleteDirectory(downloaderRoot);
		}
		afterClass();
	}
}
