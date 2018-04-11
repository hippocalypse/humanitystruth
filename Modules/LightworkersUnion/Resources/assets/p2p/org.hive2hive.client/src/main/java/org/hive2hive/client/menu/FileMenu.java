package org.hive2hive.client.menu;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;

import org.apache.commons.io.FileUtils;
import org.hive2hive.client.console.H2HConsoleMenu;
import org.hive2hive.client.console.H2HConsoleMenuItem;
import org.hive2hive.client.console.SelectionMenu;
import org.hive2hive.client.util.MenuContainer;
import org.hive2hive.core.exceptions.Hive2HiveException;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.IFileVersion;
import org.hive2hive.core.model.PermissionType;
import org.hive2hive.core.processes.files.list.FileNode;
import org.hive2hive.core.processes.files.recover.IVersionSelector;
import org.hive2hive.processframework.exceptions.InvalidProcessStateException;
import org.hive2hive.processframework.exceptions.ProcessExecutionException;
import org.hive2hive.processframework.interfaces.IProcessComponent;

public class FileMenu extends H2HConsoleMenu {

	public FileMenu(MenuContainer menus) {
		super(menus);
	}

	@Override
	protected void addMenuItems() {
		add(new H2HConsoleMenuItem("Add File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, InterruptedException, InvalidProcessStateException,
					ProcessExecutionException, ExecutionException {

				File file = askForFile(true);
				if (file == null) {
					return;
				}

				IProcessComponent<Void> addFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createAddProcess(file);
				addFileProcess.execute();
			}
		});

		add(new H2HConsoleMenuItem("Update File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, InterruptedException, InvalidProcessStateException,
					ProcessExecutionException, ExecutionException {

				File file = askForFile(true);
				if (file == null) {
					return;
				}
				IProcessComponent<Void> updateFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createUpdateProcess(file);
				updateFileProcess.execute();
			}
		});

		add(new H2HConsoleMenuItem("Download File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, InterruptedException, InvalidProcessStateException,
					ProcessExecutionException, ExecutionException {

				File file = askForFile(false);
				if (file == null) {
					return;
				}
				IProcessComponent<Void> updateFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createDownloadProcess(file);
				updateFileProcess.execute();
			}
		});

		add(new H2HConsoleMenuItem("Move File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, InterruptedException, InvalidProcessStateException,
					ProcessExecutionException, ExecutionException, IOException {
				File source = askForFile("Specify the relative path of the source file to the root directory '%s'.", true);
				if (source == null) {
					return;
				}

				File destination = askForFile(
						"Specify the relative path of the destination file to the root directory '%s'.", false);
				if (destination == null) {
					return;
				}

				IProcessComponent<Void> moveFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createMoveProcess(source, destination);
				moveFileProcess.execute();
				if (source.exists()) {
					if (source.isFile()) {
						FileUtils.moveFile(source, destination);
					} else {
						FileUtils.moveDirectory(source, destination);
					}
				}
			}
		});

		add(new H2HConsoleMenuItem("Delete File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, InterruptedException, InvalidProcessStateException,
					ProcessExecutionException, ExecutionException {
				File file = askForFile(true);
				if (file == null) {
					return;
				}

				IProcessComponent<Void> deleteFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createDeleteProcess(file);
				deleteFileProcess.execute();
				// finally delete the file
				file.delete();
			}
		});

		add(new H2HConsoleMenuItem("Recover File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws Hive2HiveException, FileNotFoundException, InterruptedException,
					InvalidProcessStateException, ProcessExecutionException, ExecutionException {

				File file = askForFile(true);
				if (file == null) {
					return;
				}

				IVersionSelector versionSelector = new IVersionSelector() {
					public IFileVersion selectVersion(List<IFileVersion> availableVersions) {
						return new SelectionMenu<IFileVersion>(availableVersions, "Choose the version you want to recover.")
								.openAndSelect();
					}

					public String getRecoveredFileName(String fullName, String name, String extension) {
						print(String
								.format("Specify the new name for the recovered file '%s' or enter 'default' to take the default values:",
										fullName));
						String input = awaitStringParameter();
						if ("default".equalsIgnoreCase(input)) {
							return null;
						} else {
							return input;
						}
					}
				};

				IProcessComponent<Void> recoverFileProcess = menus.getNodeMenu().getNode().getFileManager()
						.createRecoverProcess(file, versionSelector);
				recoverFileProcess.execute();
			}
		});

		add(new H2HConsoleMenuItem("Share File") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() throws NoSessionException, NoPeerConnectionException, InvalidProcessStateException,
					InterruptedException, ProcessExecutionException, ExecutionException {

				File folderToShare = askForFolder(
						"Specify the relative path of the folder you want to share to the root directory '%s'.", true);
				if (folderToShare == null) {
					return;
				}

				print("Specify the user ID of the user you want to share with.");
				String friendID = awaitStringParameter();

				PermissionType permission = askForPermission(folderToShare.getAbsolutePath(), friendID);
				if (permission == null) {
					return;
				}

				IProcessComponent<Void> shareProcess;
				try {
					shareProcess = menus.getNodeMenu().getNode().getFileManager()
							.createShareProcess(folderToShare, friendID, permission);
				} catch (NoPeerConnectionException | NoSessionException | IllegalArgumentException ex) {
					printError(ex.getMessage());
					return;
				}
				shareProcess.execute();
			}
		});

		add(new H2HConsoleMenuItem("Print File List") {
			@Override
			protected void execute() throws Exception {
				IProcessComponent<FileNode> fileListProcess = menus.getNodeMenu().getNode().getFileManager()
						.createFileListProcess();
				FileNode root = fileListProcess.execute();
				printRecursively(root, 0);
			}
		});

		add(new H2HConsoleMenuItem("File Observer") {
			protected boolean checkPreconditions() {
				return menus.getUserMenu().createRootDirectory();
			}

			protected void execute() {
				menus.getFileObserverMenu().open();
			}
		});
	}

	private void printRecursively(FileNode node, int level) {
		if (node.getParent() != null) {
			// skip the root node
			StringBuilder spaces = new StringBuilder("*");
			for (int i = 0; i < level; i++) {
				spaces.append(" ");
			}
			print(spaces.toString() + node.getName());
		}

		if (node.isFolder()) {
			for (FileNode child : node.getChildren()) {
				printRecursively(child, level + 1);
			}
		}
	}

	@Override
	protected String getInstruction() {
		return "Select a file operation:";
	}

	private File askForFile(boolean expectExistence) {
		return askForFile("Specify the relative path to the root directory '%s'.", expectExistence);
	}

	private File askForFile(String msg, boolean expectExistence) {
		return askFor(msg, expectExistence, false);
	}

	private File askForFolder(String msg, boolean expectExistence) {
		return askFor(msg, expectExistence, true);
	}

	private File askFor(String msg, boolean expectExistence, boolean requireDirectory) {

		// TODO find better way to exit this menu
		// TODO be more flexible with inputs, e.g. files with whitespaces in
		// name

		File rootDirectory = menus.getUserMenu().getRootDirectory();
		File file = null;
		do {
			print(String.format(msg.concat(expectExistence ? String.format(" The %s at this path must exist.",
					requireDirectory ? "folder" : "file") : ""), rootDirectory.getAbsolutePath()));
			print("Or enter 'cancel' in order to go back.");

			String input = awaitStringParameter();

			if ("cancel".equalsIgnoreCase(input)) {
				return null;
			}

			file = new File(rootDirectory, input);
			if (expectExistence && !file.exists()) {
				printError(String.format("The specified %s '%s' does not exist. Try again.", requireDirectory ? "folder"
						: "file", file.getAbsolutePath()));
				continue;
			}
			if (expectExistence && requireDirectory && !file.isDirectory()) {
				printError(String.format("The specified file '%s' is not a folder. Try again.", file.getAbsolutePath()));
			}
		} while (expectExistence && (file == null || !file.exists() || (requireDirectory && !file.isDirectory())));
		return file;
	}

	private PermissionType askForPermission(String folder, String userID) {

		List<PermissionType> permissionTypes = new ArrayList<PermissionType>();
		permissionTypes.add(PermissionType.WRITE);
		permissionTypes.add(PermissionType.READ);

		List<String> displayTexts = new ArrayList<String>();
		displayTexts.add("Read and Write");
		displayTexts.add("Read Only");

		return new SelectionMenu<PermissionType>(permissionTypes, displayTexts, String.format(
				"Specify the permissions of folder '%s' for the user '%s'.", folder, userID)).openAndSelect();
	}
}
