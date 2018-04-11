package org.hive2hive.core.security;

import java.math.BigInteger;
import java.security.GeneralSecurityException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.KeyPair;
import java.security.KeyPairGenerator;
import java.security.NoSuchAlgorithmException;
import java.security.NoSuchProviderException;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.SecureRandom;
import java.security.Signature;
import java.security.SignatureException;
import java.security.spec.RSAKeyGenParameterSpec;
import java.util.Arrays;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.KeyGenerator;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;

import org.hive2hive.core.model.versioned.HybridEncryptedContent;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * This class provides fundamental functionalities for data encryption, decryption, signing and verification.
 * Provided are both symmetric as well as asymmetric encryption approaches. Furthermore, it provides methods
 * to generate various parameters, such as keys and key pairs.
 * 
 * @author Christian
 * @author Nico
 * 
 */
public final class EncryptionUtil {

	private static final Logger logger = LoggerFactory.getLogger(EncryptionUtil.class);

	// This variable is not final in order to swap the provider with another (like SpongyCastle)
	// public static String SECURITY_PROVIDER = "BC";

	private static final String SINGATURE_ALGORITHM = "SHA1withRSA";
	// Fermat F4, largest known fermat prime
	private static final BigInteger RSA_PUBLIC_EXP = new BigInteger("10001", 16);
	private static final int IV_LENGTH = 16;

	public enum AES_KEYLENGTH {
		BIT_128(128),
		BIT_192(192),
		BIT_256(256);

		private final int bitLength;

		AES_KEYLENGTH(int length) {
			bitLength = length;
		}

		public int value() {
			return bitLength;
		}
	}

	public enum RSA_KEYLENGTH {
		BIT_512(512),
		BIT_1024(1024),
		BIT_2048(2048),
		BIT_4096(4096);

		private final int bitLength;

		RSA_KEYLENGTH(int length) {
			bitLength = length;
		}

		public int value() {
			return bitLength;
		}
	}

	private EncryptionUtil() {
	}

	/**
	 * Randomly generates an initialization vector (IV) which can be used as parameter for symmetric
	 * encryption.
	 * 
	 * @return Returns a randomly generated IV.
	 */
	public static byte[] generateIV() {
		SecureRandom random = new SecureRandom();
		byte[] iv = new byte[IV_LENGTH];
		do {
			random.nextBytes(iv);
		} while (iv[0] == 0);
		return iv;
	}

	/**
	 * Generates a symmetric AES key of the specified key length.
	 * 
	 * @param keyLength The length the AES key should have.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return A symmetric AES key of the specified length.
	 */
	public static SecretKey generateAESKey(AES_KEYLENGTH keyLength, String securityProvider) {
		try {
			final KeyGenerator kg = KeyGenerator.getInstance("AES", securityProvider);
			kg.init(keyLength.value(), new SecureRandom());
			byte[] encoded = kg.generateKey().getEncoded();
			return new SecretKeySpec(encoded, "AES");
		} catch (NoSuchAlgorithmException | NoSuchProviderException e) {
			logger.error("Exception while AES key generator instance creation:", e);
		}
		return null;

	}

	/**
	 * Generates an asymmetric RSA key pair of the specified key length.
	 * 
	 * @param keyLength The length the RSA keys should have.
	 * @return An asymmetric RSA key pair of the specified length.
	 */
	public static KeyPair generateRSAKeyPair(RSA_KEYLENGTH keyLength, String securityProvider) {
		try {
			KeyPairGenerator gen = KeyPairGenerator.getInstance("RSA", securityProvider);
			RSAKeyGenParameterSpec params = new RSAKeyGenParameterSpec(keyLength.value(), RSA_PUBLIC_EXP);
			gen.initialize(params, new SecureRandom());
			return gen.generateKeyPair();
		} catch (InvalidAlgorithmParameterException | NoSuchAlgorithmException | NoSuchProviderException e) {
			logger.error("Exception while generation of RSA key pair of length {}:", keyLength, e);
		}
		return null;
	}

	/**
	 * Symmetrically encrypts the provided data by means of the AES algorithm.
	 * 
	 * @param data The data to be encrypted.
	 * @param secretKey The symmetric key with which the data shall be encrypted.
	 * @param initVector The initialization vector (IV) with which the data shall be encrypted.
	 * @return Returns the encrypted data.
	 * @throws GeneralSecurityException in case something goes wrong
	 */
	public static byte[] encryptAES(byte[] data, SecretKey secretKey, byte[] initVector, String securityProvider,
			IStrongAESEncryption strongAES) throws GeneralSecurityException {
		int keySize = secretKey.getEncoded().length * 8;
		if (Cipher.getMaxAllowedKeyLength("AES") >= keySize) {
			return processAESCiphering(true, data, secretKey, initVector, securityProvider);
		} else {
			logger.trace("Using strong AES encryptor because key has {} bits. Max allowed are {} bits", keySize,
					Cipher.getMaxAllowedKeyLength("AES"));
			return strongAES.encryptStrongAES(data, secretKey, initVector);
		}
	}

	/**
	 * Symmetrically decrypts the provided data by means of the AES algorithm.
	 * 
	 * @param data The data to be decrypted.
	 * @param secretKey The symmetric key with which the data shall be decrypted.
	 * @param initVector The initialization vector (IV) with which the data shall be decrypted.
	 * @param strongAES
	 * @return Returns the decrypted data.
	 * @throws GeneralSecurityException in case something goes wrong
	 */
	public static byte[] decryptAES(byte[] data, SecretKey secretKey, byte[] initVector, String securityProvider,
			IStrongAESEncryption strongAES) throws GeneralSecurityException {
		int keySize = secretKey.getEncoded().length * 8;
		if (Cipher.getMaxAllowedKeyLength("AES") >= keySize) {
			return processAESCiphering(false, data, secretKey, initVector, securityProvider);
		} else {
			logger.trace("Using strong AES decryptor because key has {} bits. Max allowed are {} bits", keySize,
					Cipher.getMaxAllowedKeyLength("AES"));
			return strongAES.decryptStrongAES(data, secretKey, initVector);
		}
	}

	/**
	 * Asymmetrically encrypts the provided data by means of the RSA algorithm. In order to encrypt the
	 * content, a public RSA key has to be provided.
	 * 
	 * @param data The data to be encrypted.
	 * @param publicKey The asymmetric public key with which the data shall be encrypted.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return Returns the encrypted data.
	 * @throws InvalidKeyException
	 * @throws BadPaddingException
	 * @throws IllegalBlockSizeException
	 */
	public static byte[] encryptRSA(byte[] data, PublicKey publicKey, String securityProvider) throws InvalidKeyException,
			IllegalBlockSizeException, BadPaddingException {
		try {
			Cipher cipher = Cipher.getInstance("RSA", securityProvider);
			cipher.init(Cipher.ENCRYPT_MODE, publicKey);
			return cipher.doFinal(data);
		} catch (NoSuchAlgorithmException | NoSuchProviderException | NoSuchPaddingException e) {
			logger.error("Exception while RSA encryption:", e);
		}
		return new byte[0];
	}

	/**
	 * Asymmetrically decrypts the provided data by means of the RSA algorithm. In order to decrypt the
	 * content, a private RSA key has to be provided.
	 * 
	 * @param data The data to be decrypted.
	 * @param privateKey The asymmetric private key with which the data shall be decrypted.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return Returns the decrypted data.
	 * @throws InvalidKeyException
	 * @throws BadPaddingException
	 * @throws IllegalBlockSizeException
	 */
	public static byte[] decryptRSA(byte[] data, PrivateKey privateKey, String securityProvider) throws InvalidKeyException,
			IllegalBlockSizeException, BadPaddingException {
		try {
			Cipher cipher = Cipher.getInstance("RSA", securityProvider);
			cipher.init(Cipher.DECRYPT_MODE, privateKey);
			return cipher.doFinal(data);
		} catch (NoSuchAlgorithmException | NoSuchProviderException | NoSuchPaddingException e) {
			logger.error("Exception while RSA decryption:", e);
		}

		return new byte[0];
	}

	/**
	 * Encrypts the provided data in a hybrid manner. First, the content is symmetrically encrypted with a
	 * randomly generated IV and AES key of the specified length. Then, these encryption parameters are
	 * asymmetrically encrypted with the provided RSA public key.</br>
	 * 
	 * @param data The data to be encrypted in a hybrid manner.
	 * @param publicKey The RSA public key with which the data shall be encrypted.
	 * @param aesKeyLength The key length of the inner AES encryption.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return Returns a {@link HybridEncryptedContent} object containing the RSA encrypted parameters and the
	 *         AES encrypted content.
	 * @throws GeneralSecurityException in case something goes wrong
	 */
	public static HybridEncryptedContent encryptHybrid(byte[] data, PublicKey publicKey, AES_KEYLENGTH aesKeyLength,
			String securityProvider, IStrongAESEncryption strongAES) throws GeneralSecurityException {

		// generate AES key
		SecretKey aesKey = generateAESKey(aesKeyLength, securityProvider);
		byte[] encodedAesKey = aesKey.getEncoded();

		// generate IV
		byte[] initVector = generateIV();

		// concatenate symmetric encryption parameters -> max. 48 bytes (with AES 256) -> can be encrypted
		// with RSA 512 bit
		byte[] params = new byte[initVector.length + encodedAesKey.length];
		System.arraycopy(initVector, 0, params, 0, initVector.length);
		System.arraycopy(encodedAesKey, 0, params, initVector.length, encodedAesKey.length);

		// encrypt data symmetrically
		byte[] aesEncryptedData = encryptAES(data, aesKey, initVector, securityProvider, strongAES);

		// encrypt parameters asymmetrically
		byte[] rsaEncryptedParams = encryptRSA(params, publicKey, securityProvider);

		return new HybridEncryptedContent(rsaEncryptedParams, aesEncryptedData);
	}

	/**
	 * Decrypts the provided data in a hybrid manner. First, the symmetric encryption parameters stored in the
	 * {@link HybridEncryptedContent} are asymmetrically decrypted with the specified RSA private key. Then,
	 * the symmetrically encrypted data is decrypted by means of these parameters and then returned.
	 * 
	 * @param data The {@link HybridEncryptedContent} to be decrypted in a hybrid manner.
	 * @param privateKey The RSA private key with which the data shall be decrypted.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return Returns the decrypted data.
	 * @throws GeneralSecurityException in case something goes wrong
	 */
	public static byte[] decryptHybrid(HybridEncryptedContent data, PrivateKey privateKey, String securityProvider,
			IStrongAESEncryption strongAES) throws GeneralSecurityException {

		// decrypt parameters asymmetrically
		byte[] params = decryptRSA(data.getEncryptedParameters(), privateKey, securityProvider);

		// split symmetric encryption parameters
		byte[] initVector = Arrays.copyOfRange(params, 0, IV_LENGTH);
		byte[] encodedAesKey = Arrays.copyOfRange(params, IV_LENGTH, params.length);

		// decrypt data symmetrically
		SecretKey aesKey = new SecretKeySpec(encodedAesKey, 0, encodedAesKey.length, "AES");
		return decryptAES(data.getEncryptedData(), aesKey, initVector, securityProvider, strongAES);
	}

	/**
	 * Signs the provided data with the specified private key and returns the signature.
	 * 
	 * @param data The content to be signed.
	 * @param privateKey The private key used to sign the content.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return The created signature of the data.
	 * @throws InvalidKeyException
	 * @throws SignatureException
	 */
	public static byte[] sign(byte[] data, PrivateKey privateKey, String securityProvider) throws InvalidKeyException,
			SignatureException {
		try {
			Signature signEngine = Signature.getInstance(SINGATURE_ALGORITHM, securityProvider);
			signEngine.initSign(privateKey);
			signEngine.update(data);
			return signEngine.sign();
		} catch (NoSuchAlgorithmException | NoSuchProviderException e) {
			logger.error("Exception while signing:", e);
		}

		return new byte[0];
	}

	/**
	 * Verifies the provided signature of the provided data with the specified public key.
	 * 
	 * @param data The data to be verified.
	 * @param signature The signature with which the data should be verified.
	 * @param publicKey The public key used to verify the content.
	 * @param securityProvider the security provider (e.g. "BC" for bouncy castle)
	 * @return Returns true if the signature could be verified and false otherwise.
	 * @throws InvalidKeyException
	 * @throws SignatureException
	 */
	public static boolean verify(byte[] data, byte[] signature, PublicKey publicKey, String securityProvider)
			throws InvalidKeyException, SignatureException {
		try {
			Signature signEngine = Signature.getInstance(SINGATURE_ALGORITHM, securityProvider);
			signEngine.initVerify(publicKey);
			signEngine.update(data);
			return signEngine.verify(signature);
		} catch (NoSuchAlgorithmException | NoSuchProviderException e) {
			logger.error("Exception while verifying signature:", e);
		}

		return false;
	}

	/**
	 * Encrypts or decrypts using AES. Note that this method uses the native method and has an upper limit for
	 * the key size. If the size is too large, use {@link IStrongAESEncryption} instead.
	 */
	private static byte[] processAESCiphering(boolean forEncrypting, byte[] data, SecretKey key, byte[] initVector,
			String securityProvider) throws GeneralSecurityException {
		IvParameterSpec ivSpec = new IvParameterSpec(initVector);
		SecretKeySpec keySpec = new SecretKeySpec(key.getEncoded(), "AES");
		Cipher cipher = Cipher.getInstance("AES/CBC/PKCS7Padding", securityProvider);
		int encryptMode = forEncrypting ? Cipher.ENCRYPT_MODE : Cipher.DECRYPT_MODE;
		cipher.init(encryptMode, keySpec, ivSpec);

		// process ciphering
		byte[] output = new byte[cipher.getOutputSize(data.length)];

		int bytesProcessed1 = cipher.update(data, 0, data.length, output, 0);
		int bytesProcessed2 = cipher.doFinal(output, bytesProcessed1);

		byte[] result = new byte[bytesProcessed1 + bytesProcessed2];
		System.arraycopy(output, 0, result, 0, result.length);
		return result;

	}

	/**
	 * Converts the content of a byte array into a human readable form.
	 * 
	 * @param data The byte array to be converted.
	 * @return The hex converted byte array.
	 */
	public static String byteToHex(byte[] data) {
		StringBuilder sb = new StringBuilder();
		for (byte b : data) {
			sb.append(String.format("%02X", b));
		}
		return sb.toString();
	}
}
