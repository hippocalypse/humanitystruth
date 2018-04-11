package org.hive2hive.core.file;

import java.io.File;
import java.io.IOException;

/**
 * Since Hive2Hive does not any file operations itself, the implementation of this interface needs to be
 * provided by the user. The implementation may differ from Windows to Mac or other platforms.
 * A {@link IFileAgent} must be handed at every login and can differ between multiple users.
 * 
 * @author Nico
 *
 */
public interface IFileAgent {

	/**
	 * @return the root directory of Hive2Hive for that user
	 */
	File getRoot();

	/**
	 * Write to a persistent cache which is available after a restart.
	 * 
	 * @param key the filename or other unique key to write. If a key is re-used, the data should be
	 *            <strong>overwritten</strong>, not appended.
	 * @param data the data to write
	 * @throws IOException if writing fails
	 */
	void writeCache(String key, byte[] data) throws IOException;

	/**
	 * Reads from the cache at the given name (or key)
	 * 
	 * @param key the filename or other unique key to read from. Return either an empty byte-array or null if
	 *            the data is not available.
	 * @return the data associated with the name <code>null</code> or an empty array.
	 * @throws IOException if reading fails
	 */
	byte[] readCache(String key) throws IOException;
}
