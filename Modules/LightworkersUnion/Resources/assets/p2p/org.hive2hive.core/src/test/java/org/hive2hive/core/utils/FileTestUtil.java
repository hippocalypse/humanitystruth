package org.hive2hive.core.utils;

import java.io.File;
import java.io.IOException;

import org.apache.commons.io.FileUtils;
import org.hive2hive.core.H2HJUnitTest;
import org.hive2hive.core.file.FileUtil;
import org.junit.Assert;

public class FileTestUtil {

	/**
	 * Create a file of a given size (using the default test chunk size)
	 */
	public static File createFileRandomContent(int numOfChunks, File parent) throws IOException {
		return createFileRandomContent(H2HJUnitTest.randomString(), numOfChunks, parent, TestFileConfiguration.CHUNK_SIZE);
	}

	public static File createFileRandomContent(int numOfChunks, File parent, int chunkSize) throws IOException {
		return createFileRandomContent(H2HJUnitTest.randomString(), numOfChunks, parent, chunkSize);
	}

	public static File createFileRandomContent(String fileName, int numOfChunks, File parent) throws IOException {
		return createFileRandomContent(fileName, numOfChunks, parent, TestFileConfiguration.CHUNK_SIZE);
	}

	public static File createFileRandomContent(String fileName, int numOfChunks, File parent, int chunkSize)
			throws IOException {
		// create file of size of multiple numbers of chunks
		File file = new File(parent, fileName);
		while (Math.ceil(1.0 * FileUtil.getFileSize(file) / chunkSize) < numOfChunks) {
			String random = H2HJUnitTest.randomString((int) chunkSize - 1);
			FileUtils.write(file, random, true);
		}

		return file;
	}

	public static File getTempDirectory() {
		File dir = new File(FileUtils.getTempDirectory(), H2HJUnitTest.randomString());
		Assert.assertTrue(dir.mkdirs());
		return dir;
	}
}
