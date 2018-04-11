package org.hive2hive.core.events.framework.interfaces;

import net.engio.mbassy.listener.Handler;

import org.hive2hive.core.events.framework.interfaces.file.IFileAddEvent;
import org.hive2hive.core.events.framework.interfaces.file.IFileDeleteEvent;
import org.hive2hive.core.events.framework.interfaces.file.IFileMoveEvent;
import org.hive2hive.core.events.framework.interfaces.file.IFileShareEvent;
import org.hive2hive.core.events.framework.interfaces.file.IFileUpdateEvent;

public interface IFileEventListener {

	@Handler
	void onFileAdd(IFileAddEvent fileEvent);

	@Handler
	void onFileUpdate(IFileUpdateEvent fileEvent);

	@Handler
	void onFileDelete(IFileDeleteEvent fileEvent);

	@Handler
	void onFileMove(IFileMoveEvent fileEvent);

	@Handler
	void onFileShare(IFileShareEvent fileEvent);
}
