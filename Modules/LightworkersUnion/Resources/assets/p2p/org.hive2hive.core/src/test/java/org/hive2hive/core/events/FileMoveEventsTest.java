package org.hive2hive.core.events;

import static org.junit.Assert.assertFalse;
import static org.junit.Assert.assertTrue;

import java.io.File;
import java.io.IOException;
import java.util.List;

import org.hive2hive.core.events.framework.interfaces.file.IFileEvent;
import org.hive2hive.core.events.framework.interfaces.file.IFileMoveEvent;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.utils.UseCaseTestUtil;
import org.junit.Test;

public class FileMoveEventsTest extends FileEventsTest {

	static {
		testClass = FileMoveEventsTest.class;
	}

	@Test
	public void testFileMoveEvent() throws NoPeerConnectionException, IOException, NoSessionException {
		// upload a file from machine A
		File file = createAndAddFile(rootA, clientA);
		File dst = new File(rootA, randomString(12));

		waitForNumberOfEvents(1);

		listener.getEvents().clear();
		UseCaseTestUtil.moveFile(clientA, file, dst);
		waitForNumberOfEvents(1);
		List<IFileEvent> events = listener.getEvents();
		assertEventType(events, IFileMoveEvent.class);
		assertTrue(events.size() == 1);

		// compare src/dst paths of A and B
		IFileMoveEvent e = (IFileMoveEvent) events.get(0);
		assertEqualsRelativePaths(file, e.getSrcFile());
		assertEqualsRelativePaths(dst, e.getDstFile());

		assertTrue(e.isFile());
		assertFalse(e.isFolder());
	}

	@Test
	public void testEmptyFolderMoveEvent() throws NoPeerConnectionException, IOException, NoSessionException {
		// upload a folder from machine A
		File folder = createAndAddFolder(rootA, clientA);
		File dst = new File(rootA, randomString(12));

		waitForNumberOfEvents(1);

		listener.getEvents().clear();
		UseCaseTestUtil.moveFile(clientA, folder, dst);
		waitForNumberOfEvents(1);
		List<IFileEvent> events = listener.getEvents();
		assertEventType(events, IFileMoveEvent.class);
		assertTrue(events.size() == 1);

		// compare src/dst paths of A and B
		IFileMoveEvent e = (IFileMoveEvent) events.get(0);
		assertEqualsRelativePaths(folder, e.getSrcFile());
		assertEqualsRelativePaths(dst, e.getDstFile());

		assertFalse(e.isFile());
		assertTrue(e.isFolder());
	}

	@Test
	public void testFolderWithFilesMoveEvent() throws NoPeerConnectionException, IOException, NoSessionException {
		List<File> files = createAndAddFolderWithFiles(rootA, clientA);
		File folder = files.get(0);
		File dst = new File(rootA, randomString(12));

		waitForNumberOfEvents(files.size());
		listener.getEvents().clear();
		UseCaseTestUtil.moveFile(clientA, folder, dst);

		waitForNumberOfEvents(1);

		List<IFileEvent> events = listener.getEvents();
		assertEventType(events, IFileMoveEvent.class);
		assertTrue(events.size() == 1);

		// compare src/dst paths of A and B
		IFileMoveEvent e = (IFileMoveEvent) events.get(0);
		assertEqualsRelativePaths(folder, e.getSrcFile());
		assertEqualsRelativePaths(dst, e.getDstFile());

		assertFalse(e.isFile());
		assertTrue(e.isFolder());
	}
}
