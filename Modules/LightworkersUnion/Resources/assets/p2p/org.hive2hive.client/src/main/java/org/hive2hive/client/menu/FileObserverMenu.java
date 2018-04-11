package org.hive2hive.client.menu;

import org.hive2hive.client.console.H2HConsoleMenu;
import org.hive2hive.client.console.H2HConsoleMenuItem;
import org.hive2hive.client.util.FileObserver;
import org.hive2hive.client.util.FileObserverListener;
import org.hive2hive.client.util.MenuContainer;

public class FileObserverMenu extends H2HConsoleMenu {

	private FileObserver fileObserver;
	private long interval = 1000;

	public FileObserverMenu(MenuContainer menus) {
		super(menus);
	}

	@Override
	protected void addMenuItems() {

		if (isExpertMode) {
			add(new H2HConsoleMenuItem("Set Interval") {
				// TODO restart observer
				protected void execute() {
					System.out.println("Specify the observation interval (ms):");
					interval = awaitIntParameter();
				}
			});
		}

		add(new H2HConsoleMenuItem("Start File Observer") {
			protected boolean checkPreconditions() {
				if (menus.getNodeMenu().createNetwork()) {
					return menus.getUserMenu().createRootDirectory();
				} else {
					return false;
				}
			}

			protected void execute() throws Exception {
				fileObserver = new FileObserver(menus.getUserMenu().getRootDirectory(), interval);
				FileObserverListener listener = new FileObserverListener(menus.getNodeMenu().getNode().getFileManager());
				fileObserver.addFileObserverListener(listener);

				fileObserver.start();
				exit();
			}
		});

		add(new H2HConsoleMenuItem("Stop File Observer") {
			protected void execute() throws Exception {
				if (fileObserver != null) {
					fileObserver.stop();
				}
				exit();
			}
		});

	}

	@Override
	protected String getInstruction() {
		String rootPath = menus.getUserMenu().getRootDirectory().toString();

		if (isExpertMode) {
			return String.format("Configure and start/stop the file observer for '%s':", rootPath);
		} else {
			return String.format("Start/stop the file observer for '%s':", rootPath);
		}
	}

	public FileObserver getFileObserver() {
		return fileObserver;
	}

}
