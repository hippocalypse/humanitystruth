package org.hive2hive.core.extras;

import java.io.File;
import java.io.IOException;
import java.security.KeyPair;
import java.util.List;
import java.util.Map;

import org.apache.commons.io.FileUtils;
import org.hive2hive.core.H2HConstants;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.model.FileIndex;
import org.hive2hive.core.model.FolderIndex;
import org.hive2hive.core.model.Index;
import org.hive2hive.core.model.versioned.UserProfile;
import org.hive2hive.core.security.EncryptionUtil.RSA_KEYLENGTH;
import org.hive2hive.core.security.HashUtil;
import org.hive2hive.core.utils.FileTestUtil;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

public class FileSynchronizerTest extends H2HJUnitTest {

	private File rootFile;

	private FolderIndex root;
	private FileIndex node1f1;
	private FileIndex node1f2;
	private FolderIndex node1d;
	private FileIndex node2f;
	private Index node2d;
	private File file1f1;
	private File file1f2;
	private File file1d;
	private File file2f;
	private File file2d;
	private UserProfile userProfile;

	@BeforeClass
	public static void initTest() throws Exception {
		testClass = FileSynchronizerTest.class;
		beforeClass();
	}

	@AfterClass
	public static void cleanAfterClass() {
		afterClass();
	}

	@Before
	public void createTreeNode() throws IOException {
		rootFile = FileTestUtil.getTempDirectory();

		// naming convention:
		// [number][type][index] where number is the level and type is either 'f' for file or 'd' for
		// directory. The index is to distinct two files/folders on the same level

		// setup is like
		// root:
		// - 1f1
		// - 1f2
		// - 1d:
		// - - 2f
		// - - 2d (empty folder)
		file1f1 = new File(rootFile, "1f1");
		FileUtils.writeStringToFile(file1f1, randomString());
		file1f2 = new File(rootFile, "1f2");
		FileUtils.writeStringToFile(file1f2, randomString());
		file1d = new File(rootFile, "1d");
		file1d.mkdirs();
		file2f = new File(file1d, "2f");
		FileUtils.writeStringToFile(file2f, randomString());
		file2d = new File(file1d, "2d");
		file2d.mkdir();

		KeyPair keys = generateRSAKeyPair(RSA_KEYLENGTH.BIT_512);
		userProfile = new UserProfile("test-user", keys, keys);
		root = userProfile.getRoot();
		node1f1 = new FileIndex(root, keys, "1f1", HashUtil.hash(file1f1));
		node1f2 = new FileIndex(root, keys, "1f2", HashUtil.hash(file1f2));
		node1d = new FolderIndex(root, keys, "1d");
		node2f = new FileIndex(node1d, keys, "2f", HashUtil.hash(file2f));
		node2d = new FolderIndex(node1d, keys, "2d");
	}

	@After
	public void cleanup() throws IOException {
		FileUtils.deleteDirectory(rootFile);
	}

	@Test
	public void testDeletedLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);
		file1f1.delete();
		file2d.delete();
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<Index> deletedLocally = fileSynchronizer.getDeletedLocally();
		Assert.assertEquals(2, deletedLocally.size());
		Assert.assertTrue(deletedLocally.contains(node1f1));
		Assert.assertTrue(deletedLocally.contains(node2d));
	}

	@Test
	public void testDeletedRemotely() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);
		root.removeChild(node1f1);
		root.removeChild(node1d); // delete whole directory
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<File> deletedRemotely = fileSynchronizer.getDeletedRemotely();
		Assert.assertEquals(4, deletedRemotely.size());
		Assert.assertTrue(deletedRemotely.contains(file1f1));
		Assert.assertTrue(deletedRemotely.contains(file1d));
		Assert.assertTrue(deletedRemotely.contains(file2f));
		Assert.assertTrue(deletedRemotely.contains(file2d));
	}

	@Test
	public void testAddedLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);
		// one folder
		File file2d2 = new File(file1d, "2d2");
		file2d2.mkdir();

		// one file
		File file1f3 = new File(rootFile, "1f3");
		FileUtils.writeStringToFile(file1f3, randomString());
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<File> addedLocally = fileSynchronizer.getAddedLocally();
		Assert.assertEquals(2, addedLocally.size());
		Assert.assertTrue(addedLocally.contains(file2d2));
		Assert.assertTrue(addedLocally.contains(file1f3));
	}

	@Test
	public void testAddedRemotely() throws IOException, ClassNotFoundException {
		KeyPair keys = generateRSAKeyPair(H2HConstants.KEYLENGTH_META_FILE);
		Index node1f3 = new FileIndex(root, keys, "1f3", null);
		Index node2d2 = new FolderIndex(node1d, keys, "2d2");

		Map<String, byte[]> same = FileSynchronizer.visitFiles(rootFile);
		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, same, same);
		List<Index> addedRemotely = fileSynchronizer.getAddedRemotely();
		Assert.assertEquals(2, addedRemotely.size());
		Assert.assertTrue(addedRemotely.contains(node1f3));
		Assert.assertTrue(addedRemotely.contains(node2d2));
	}

	@Test
	public void testUpdatedLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);

		// change two files
		FileUtils.writeStringToFile(file1f2, randomString());
		FileUtils.writeStringToFile(file2f, randomString());
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<File> updatedLocally = fileSynchronizer.getUpdatedLocally();
		Assert.assertEquals(2, updatedLocally.size());
		Assert.assertTrue(updatedLocally.contains(file1f2));
		Assert.assertTrue(updatedLocally.contains(file2f));

		// change file in user profile as well --> should not occur as updated locally
		node1f2.setMD5(HashUtil.hash(randomString().getBytes()));

		fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		updatedLocally = fileSynchronizer.getUpdatedLocally();
		Assert.assertEquals(1, updatedLocally.size());
		Assert.assertTrue(updatedLocally.contains(file2f));
	}

	@Test
	public void testUpdatedRemotely() throws IOException, ClassNotFoundException {
		// change two files in the user profile; hashes on disk remain the same
		node1f2.setMD5(HashUtil.hash(randomString().getBytes()));
		node2f.setMD5(HashUtil.hash(randomString().getBytes()));

		Map<String, byte[]> same = FileSynchronizer.visitFiles(rootFile);
		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, same, same);
		List<FileIndex> updatedRemotely = fileSynchronizer.getUpdatedRemotely();
		Assert.assertEquals(2, updatedRemotely.size());
		Assert.assertTrue(updatedRemotely.contains(node1f2));
		Assert.assertTrue(updatedRemotely.contains(node2f));
	}

	@Test
	public void testNothingChanged() throws ClassNotFoundException, IOException {
		// nothing has changed --> should receive no file to upload/download
		Map<String, byte[]> same = FileSynchronizer.visitFiles(rootFile);
		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, same, same);
		Assert.assertEquals(0, fileSynchronizer.getUpdatedRemotely().size());
		Assert.assertEquals(0, fileSynchronizer.getUpdatedLocally().size());
		Assert.assertEquals(0, fileSynchronizer.getAddedRemotely().size());
		Assert.assertEquals(0, fileSynchronizer.getAddedLocally().size());
		Assert.assertEquals(0, fileSynchronizer.getDeletedRemotely().size());
		Assert.assertEquals(0, fileSynchronizer.getDeletedLocally().size());
	}

	@Test
	public void testConflictUpdateLocallyDeleteRemotely() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);

		// change a file locally
		FileUtils.writeStringToFile(file1f2, randomString());

		// delete the same file remotely
		root.removeChild(node1f2);
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<File> addedLocally = fileSynchronizer.getAddedLocally();
		Assert.assertEquals(1, addedLocally.size());
		Assert.assertTrue(addedLocally.contains(file1f2));

		List<File> deletedRemotely = fileSynchronizer.getDeletedRemotely();
		Assert.assertTrue(deletedRemotely.isEmpty());
	}

	@Test
	public void testConflictUpdateRemotelyDeleteLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);

		// delete a file locally
		file1f2.delete();

		// modify the same file remotely
		node1f2.setMD5(HashUtil.hash(randomString().getBytes()));
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<Index> addedRemotely = fileSynchronizer.getAddedRemotely();
		Assert.assertEquals(1, addedRemotely.size());
		Assert.assertTrue(addedRemotely.contains(node1f2));

		List<FileIndex> updatedRemotely = fileSynchronizer.getUpdatedRemotely();
		Assert.assertTrue(updatedRemotely.isEmpty());

		List<Index> deletedLocally = fileSynchronizer.getDeletedLocally();
		Assert.assertTrue(deletedLocally.isEmpty());
	}

	@Test
	public void testConflictUpdateRemotelyAndLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);

		// change a file in the user profile
		node1f2.setMD5(HashUtil.hash(randomString().getBytes()));

		// change file on disk as well --> should occur as updated remotely since there is a conflict and the
		// profile wins
		FileUtils.writeStringToFile(file1f2, randomString());
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<FileIndex> updatedRemotely = fileSynchronizer.getUpdatedRemotely();
		Assert.assertEquals(1, updatedRemotely.size());
		Assert.assertTrue(updatedRemotely.contains(node1f2));

		List<File> updatedLocally = fileSynchronizer.getUpdatedLocally();
		Assert.assertTrue(updatedLocally.isEmpty());
	}

	@Test
	public void testConflictDeleteRemotelyAndLocally() throws IOException, ClassNotFoundException {
		Map<String, byte[]> before = FileSynchronizer.visitFiles(rootFile);

		// remove a file in the user profile and on disk
		root.removeChild(node1f2);
		file1f2.delete();
		Map<String, byte[]> after = FileSynchronizer.visitFiles(rootFile);

		FileSynchronizer fileSynchronizer = new FileSynchronizer(rootFile, userProfile, before, after);
		List<Index> deletedRemotely = fileSynchronizer.getDeletedLocally();
		Assert.assertTrue(deletedRemotely.isEmpty());

		List<File> updatedLocally = fileSynchronizer.getDeletedRemotely();
		Assert.assertTrue(updatedLocally.isEmpty());
	}
}
