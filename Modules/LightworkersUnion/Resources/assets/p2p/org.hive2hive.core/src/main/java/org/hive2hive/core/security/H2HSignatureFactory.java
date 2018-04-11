package org.hive2hive.core.security;

import io.netty.buffer.ByteBuf;

import java.io.IOException;
import java.nio.ByteBuffer;
import java.security.InvalidKeyException;
import java.security.KeyFactory;
import java.security.NoSuchAlgorithmException;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.Signature;
import java.security.SignatureException;
import java.security.spec.InvalidKeySpecException;
import java.security.spec.X509EncodedKeySpec;

import net.tomp2p.connection.SignatureFactory;
import net.tomp2p.message.SignatureCodec;
import net.tomp2p.p2p.PeerBuilder;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * The signature is done with SHA1withRSA.
 *
 * @author Seppi
 * @author Nico
 */
public class H2HSignatureFactory implements SignatureFactory {

	private static final long serialVersionUID = -8522085229948986395L;
	private static final Logger logger = LoggerFactory.getLogger(H2HSignatureFactory.class);

	/**
	 * @return The signature mechanism
	 */
	private Signature signatureInstance() {
		try {
			return Signature.getInstance("SHA1withRSA");
		} catch (NoSuchAlgorithmException e) {
			logger.error("Could not find signature algorithm:", e);
			return null;
		}
	}

	@Override
	public PublicKey decodePublicKey(final byte[] me) {
		X509EncodedKeySpec pubKeySpec = new X509EncodedKeySpec(me);
		try {
			KeyFactory keyFactory = KeyFactory.getInstance("RSA");
			return keyFactory.generatePublic(pubKeySpec);
		} catch (NoSuchAlgorithmException e) {
			logger.error("Could not find decoding algorithm:", e);
			return null;
		} catch (InvalidKeySpecException e) {
			logger.error("Invalid key specs provided:", e);
			return null;
		}
	}

	// decodes with header
	@Override
	public PublicKey decodePublicKey(ByteBuf buf) {
		if (buf.readableBytes() < 2) {
			return null;
		}
		int len = buf.getUnsignedShort(buf.readerIndex());

		if (buf.readableBytes() - 2 < len) {
			return null;
		}
		buf.skipBytes(2);

		if (len <= 0) {
			return PeerBuilder.EMPTY_PUBLIC_KEY;
		}

		byte[] me = new byte[len];
		buf.readBytes(me);
		return decodePublicKey(me);
	}

	@Override
	public void encodePublicKey(PublicKey publicKey, ByteBuf buf) {
		byte[] data = publicKey.getEncoded();
		buf.writeShort(data.length);
		buf.writeBytes(data);
	}

	@Override
	public SignatureCodec sign(PrivateKey privateKey, ByteBuffer[] byteBuffers) throws InvalidKeyException,
			SignatureException, IOException {
		Signature signature = signatureInstance();
		signature.initSign(privateKey);
		int len = byteBuffers.length;
		for (int i = 0; i < len; i++) {
			ByteBuffer buffer = byteBuffers[i];
			signature.update(buffer);
		}

		byte[] signatureData = signature.sign();
		SignatureCodec decodedSignature = new H2HSignatureCodec(signatureData);
		return decodedSignature;
	}

	@Override
	public boolean verify(PublicKey publicKey, ByteBuffer[] byteBuffers, SignatureCodec signatureCodec)
			throws SignatureException, InvalidKeyException {
		Signature signature = signatureInstance();
		signature.initVerify(publicKey);
		int len = byteBuffers.length;
		for (int i = 0; i < len; i++) {
			ByteBuffer buffer = byteBuffers[i];
			signature.update(buffer);
		}

		byte[] signatureReceived = signatureCodec.encode();
		return signature.verify(signatureReceived);
	}

	@Override
	public Signature update(PublicKey receivedPublicKey, ByteBuffer[] byteBuffers) throws InvalidKeyException,
			SignatureException {
		Signature signature = signatureInstance();
		signature.initVerify(receivedPublicKey);
		int arrayLength = byteBuffers.length;
		for (int i = 0; i < arrayLength; i++) {
			signature.update(byteBuffers[i]);
		}
		return signature;
	}

	@Override
	public SignatureCodec signatureCodec(ByteBuf buf) {
		return new H2HSignatureCodec(buf);
	}

	@Override
	public int signatureSize() {
		return H2HSignatureCodec.SIGNATURE_SIZE;
	}
}
