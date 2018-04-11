package org.hive2hive.core;

import java.security.KeyPair;
import java.security.SecureRandom;
import java.security.Security;
import java.util.Random;
import java.util.UUID;

import org.bouncycastle.jce.provider.BouncyCastleProvider;
import org.hive2hive.core.security.EncryptionUtil;
import org.hive2hive.core.security.EncryptionUtil.RSA_KEYLENGTH;
import org.hive2hive.core.security.UserCredentials;
import org.junit.After;
import org.junit.Before;
import org.junit.Rule;
import org.junit.rules.TestName;
import org.junit.rules.Timeout;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class H2HJUnitTest {
	private static final String START_STRING = "Start ";
	private static final String END_STRING = "End ";

	protected static final int DEFAULT_NETWORK_SIZE = 3;
	protected static Class<? extends H2HJUnitTest> testClass;
	protected static Logger logger;

	@Rule
	public TestName name = new TestName();

	@Rule
	public Timeout globalTimeout = new Timeout(5 * 60 * 1000); // 5 minutes max per method tested

	@Before
	public void beforeMethod() {
		logger.info(createMessage(name.getMethodName(), true));
	}

	@After
	public void afterMethod() {
		logger.info(createMessage(name.getMethodName(), false));
	}

	public static final void beforeClass() throws Exception {
		logger = LoggerFactory.getLogger(testClass);
		printTestIdentifier(testClass.getName(), true);
	}

	protected static void printTestIdentifier(String name, boolean isStart) {
		String bar = createBars(name, isStart);
		if (isStart) {
			logger.debug("");
		}
		logger.debug(bar);
		logger.info(createMessage(name, isStart));
		logger.debug(bar);
		if (!isStart) {
			logger.debug("");
		}

	}

	private static String createMessage(String name, boolean isStart) {
		StringBuffer message = new StringBuffer("--- ");
		if (isStart) {
			message.append(START_STRING);
		} else {
			message.append(END_STRING);
		}
		message.append(name);
		message.append(" ---");
		return message.toString();
	}

	private static String createBars(String name, boolean isStart) {
		StringBuffer bar = new StringBuffer();
		bar.append("----");
		int mitPart = name.length();
		if (isStart) {
			mitPart += START_STRING.length();
		} else {
			mitPart += END_STRING.length();
		}
		for (int i = 0; i < mitPart; i++) {
			bar.append("-");
		}
		bar.append("----");
		return bar.toString();
	}

	public static void afterClass() {
		printTestIdentifier(testClass.getName(), false);
	}

	protected static byte[] generateRandomContent(int sizeInBytes) {
		SecureRandom random = new SecureRandom();
		byte[] content = new byte[random.nextInt(sizeInBytes)];
		random.nextBytes(content);
		return content;
	}

	protected static byte[] generateFixedContent(int sizeInBytes) {
		SecureRandom random = new SecureRandom();
		byte[] content = new byte[sizeInBytes];
		random.nextBytes(content);
		return content;
	}

	public static String randomString(int maxLength) {
		assert maxLength > 1;

		Random random = new Random();
		char[] subset = "0123456789abcdefghijklmnopqrstuvwxyz".toCharArray();

		int length = 0;
		while (length < 1) {
			length = random.nextInt(maxLength);
		}
		char buf[] = new char[length];
		for (int i = 0; i < buf.length; i++) {
			int index = random.nextInt(subset.length);
			buf[i] = subset[index];
		}

		return new String(buf);
	}

	public static String randomString() {
		return UUID.randomUUID().toString();
	}

	public static UserCredentials generateRandomCredentials() {
		return new UserCredentials(randomString(), randomString(), randomString());
	}

	public static UserCredentials generateRandomCredentials(String userName) {
		return new UserCredentials(userName, randomString(), randomString());
	}

	public static KeyPair generateRSAKeyPair(RSA_KEYLENGTH size) {
		if (Security.getProvider(BouncyCastleProvider.PROVIDER_NAME) == null) {
			Security.addProvider(new BouncyCastleProvider());
		}

		return EncryptionUtil.generateRSAKeyPair(size, BouncyCastleProvider.PROVIDER_NAME);
	}

	protected static void printBytes(String description, byte[] bytes) {
		logger.debug(description);
		logger.debug(EncryptionUtil.byteToHex(bytes));
	}

}
