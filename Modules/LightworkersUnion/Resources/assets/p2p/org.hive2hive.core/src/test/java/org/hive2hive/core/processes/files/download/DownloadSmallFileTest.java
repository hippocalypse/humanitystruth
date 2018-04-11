package org.hive2hive.core.processes.files.download;

import java.io.File;
import java.io.IOException;
import java.security.KeyPair;
import java.util.List;

import org.apache.commons.io.FileUtils;
import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.exceptions.GetFailedException;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.model.versioned.UserProfile;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.processes.ProcessFactory;
import org.hive2hive.core.security.HashUtil;
import org.hive2hive.core.security.UserCredentials;
import org.hive2hive.core.utils.FileTestUtil;
import org.hive2hive.core.utils.NetworkTestUtil;
import org.hive2hive.core.utils.TestExecutionUtil;
import org.hive2hive.core.utils.UseCaseTestUtil;
import org.hive2hive.core.utils.helper.DenyingMessageReplyHandler;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.interfaces.IProcessComponent;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

/**
 * Tests downloading a file.
 * 
 * @author Nico, Seppi
 */
public class DownloadSmallFileTest extends H2HJUnitTest {

	private static List<NetworkManager> network;
	private static NetworkManager uploader;
	private static NetworkManager downloader;
	private static UserCredentials userCredentials;
	private static File uploaderRoot;
	private static File downloaderRoot;

	// new for every test method
	private File uploadedFile;
	private String testContent;
	private Index fileNode;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = DownloadSmallFileTest.class;
		beforeClass();
		// setup a network
		network = NetworkTestUtil.createNetwork(DEFAULT_NETWORK_SIZE);
		uploader = network.get(0);
		downloader = network.get(1);

		// create user, register and login both clients
		userCredentials = generateRandomCredentials();
		uploaderRoot = FileTestUtil.getTempDirectory();
		UseCaseTestUtil.registerAndLogin(userCredentials, uploader, uploaderRoot);
		downloaderRoot = new File(FileUtils.getTempDirectory(), randomString());
		UseCaseTestUtil.login(userCredentials, downloader, downloaderRoot);

		// workaround that the downloader does not get notified about the newly added file (it will be done
		// manually)
		downloader.getConnection().getPeer().peer().objectDataReply(new DenyingMessageReplyHandler());
	}

	@Before
	public void uploadFile() throws IOException, NoSessionException, NoPeerConnectionException, GetFailedException {
		// upload a small file
		uploadedFile = FileTestUtil.createFileRandomContent(3, uploaderRoot);
		testContent = FileUtils.readFileToString(uploadedFile);
		UseCaseTestUtil.uploadNewFile(uploader, uploadedFile);
		UserProfile up = UseCaseTestUtil.getUserProfile(network.get(0), userCredentials);
		fileNode = up.getRoot().getChildByName(uploadedFile.getName());
	}

	@Test
	public void testDownloadSmallFile() throws IOException, NoSessionException, GetFailedException,
			NoPeerConnectionException {
		// download file
		UseCaseTestUtil.downloadFile(downloader, fileNode.getFilePublicKey());

		// the downloaded file should now be on the disk
		File downloadedFile = new File(downloaderRoot, fileNode.getName());
		Assert.assertTrue(downloadedFile.exists());

		String content = FileUtils.readFileToString(downloadedFile);
		Assert.assertEquals(testContent, content);
	}

	@Test
	public void testDownloadWrongKeys() throws IOException, NoSessionException, GetFailedException,
			InvalidProcessStateException, NoPeerConnectionException {
		// create fake file keys
		KeyPair wrongKeys = generateRSAKeyPair(H2HConstants.KEYLENGTH_META_FILE);

		// try to download with wrong keys
		IProcessComponent<Void> process = ProcessFactory.instance().createDownloadFileProcess(wrongKeys.getPublic(),
				downloader);
		TestExecutionUtil.executeProcessTillFailed(process);
	}

	@Test
	// should overwrite the existing file
	public void testDownloadFileAlreadyExisting() throws IOException, NoSessionException, GetFailedException,
			NoPeerConnectionException {
		// create the existing file
		File existing = new File(downloaderRoot, uploadedFile.getName());
		FileUtils.write(existing, "existing content");
		byte[] md5Before = HashUtil.hash(existing);

		UseCaseTestUtil.downloadFile(downloader, fileNode.getFilePublicKey());

		// the downloaded file should now be on the disk
		File downloadedFile = new File(downloaderRoot, fileNode.getName());
		Assert.assertTrue(downloadedFile.exists());

		String content = FileUtils.readFileToString(downloadedFile);
		Assert.assertEquals(testContent, content);

		// the content of the existing file is modified
		Assert.assertFalse(HashUtil.compare(downloadedFile, md5Before));
	}

	@Test
	// should NOT overwrite the existing file
	public void testDownloadFileAlreadyExistingSameContent() throws IOException, NoSessionException,
			InvalidProcessStateException, NoPeerConnectionException, GetFailedException {
		// create the existing file
		File existing = new File(downloaderRoot, uploadedFile.getName());
		FileUtils.write(existing, FileUtils.readFileToString(uploadedFile));
		long lastModifiedBefore = existing.lastModified();

		IProcessComponent<Void> process = ProcessFactory.instance().createDownloadFileProcess(fileNode.getFilePublicKey(),
				downloader);
		TestExecutionUtil.executeProcessTillFailed(process);

		// the existing file has already same content, should not have been downloaded
		Assert.assertEquals(lastModifiedBefore, existing.lastModified());
	}

	@After
	public void deleteFile() {
		FileUtils.deleteQuietly(uploadedFile);
	}

	@AfterClass
	public static void endTest() throws IOException {
		NetworkTestUtil.shutdownNetwork(network);
		FileUtils.deleteDirectory(uploaderRoot);
		FileUtils.deleteDirectory(downloaderRoot);
		afterClass();
	}
}
