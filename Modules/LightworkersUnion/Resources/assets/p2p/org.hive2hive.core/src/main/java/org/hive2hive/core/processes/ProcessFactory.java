package org.hive2hive.core.processes;

import java.io.File;
import java.security.PublicKey;
import java.util.Set;

import org.hive2hive.core.H2HSession;
import org.hive2hive.core.api.interfaces.IFileConfiguration;
import org.hive2hive.core.exceptions.NoPeerConnectionException;
import org.hive2hive.core.exceptions.NoSessionException;
import org.hive2hive.core.model.UserPermission;
import org.hive2hive.core.network.NetworkManager;
import org.hive2hive.core.network.data.DataManager;
import org.hive2hive.core.processes.common.userprofiletask.GetUserProfileTaskStep;
import org.hive2hive.core.processes.context.AddFileProcessContext;
import org.hive2hive.core.processes.context.DeleteFileProcessContext;
import org.hive2hive.core.processes.context.DownloadFileContext;
import org.hive2hive.core.processes.context.LoginProcessContext;
import org.hive2hive.core.processes.context.MoveFileProcessContext;
import org.hive2hive.core.processes.context.NotifyProcessContext;
import org.hive2hive.core.processes.context.RecoverFileContext;
import org.hive2hive.core.processes.context.RegisterProcessContext;
import org.hive2hive.core.processes.context.ShareProcessContext;
import org.hive2hive.core.processes.context.UpdateFileProcessContext;
import org.hive2hive.core.processes.context.UserProfileTaskContext;
import org.hive2hive.core.processes.context.interfaces.INotifyContext;
import org.hive2hive.core.processes.files.CheckWriteAccessStep;
import org.hive2hive.core.processes.files.GetFileKeysStep;
import org.hive2hive.core.processes.files.GetMetaFileStep;
import org.hive2hive.core.processes.files.InitializeChunksStep;
import org.hive2hive.core.processes.files.InitializeMetaUpdateStep;
import org.hive2hive.core.processes.files.PutMetaFileStep;
import org.hive2hive.core.processes.files.ValidateFileStep;
import org.hive2hive.core.processes.files.add.AddIndexToUserProfileStep;
import org.hive2hive.core.processes.files.add.CreateFileKeysStep;
import org.hive2hive.core.processes.files.add.CreateMetaFileStep;
import org.hive2hive.core.processes.files.add.PrepareAddNotificationStep;
import org.hive2hive.core.processes.files.delete.DeleteFromUserProfileStep;
import org.hive2hive.core.processes.files.delete.PrepareDeleteNotificationStep;
import org.hive2hive.core.processes.files.download.FindInUserProfileStep;
import org.hive2hive.core.processes.files.list.FileNode;
import org.hive2hive.core.processes.files.list.GetFileListStep;
import org.hive2hive.core.processes.files.move.RelinkUserProfileStep;
import org.hive2hive.core.processes.files.recover.IVersionSelector;
import org.hive2hive.core.processes.files.recover.SelectVersionStep;
import org.hive2hive.core.processes.files.update.CleanupChunksStep;
import org.hive2hive.core.processes.files.update.CreateNewVersionStep;
import org.hive2hive.core.processes.files.update.PrepareUpdateNotificationStep;
import org.hive2hive.core.processes.files.update.UpdateMD5inUserProfileStep;
import org.hive2hive.core.processes.login.ContactOtherClientsStep;
import org.hive2hive.core.processes.login.GetLocationsStep;
import org.hive2hive.core.processes.login.SessionCreationStep;
import org.hive2hive.core.processes.login.SessionParameters;
import org.hive2hive.core.processes.logout.DeleteSessionStep;
import org.hive2hive.core.processes.logout.RemoveOwnLocationsStep;
import org.hive2hive.core.processes.logout.StopDownloadsStep;
import org.hive2hive.core.processes.logout.StopUserQueueWorkerStep;
import org.hive2hive.core.processes.logout.WritePersistentStep;
import org.hive2hive.core.processes.notify.BaseNotificationMessageFactory;
import org.hive2hive.core.processes.notify.GetAllLocationsStep;
import org.hive2hive.core.processes.notify.GetPublicKeysStep;
import org.hive2hive.core.processes.notify.PutAllUserProfileTasksStep;
import org.hive2hive.core.processes.notify.SendNotificationsMessageStep;
import org.hive2hive.core.processes.notify.VerifyNotificationFactoryStep;
import org.hive2hive.core.processes.register.CheckIsUserRegisteredStep;
import org.hive2hive.core.processes.register.PutPublicKeyStep;
import org.hive2hive.core.processes.register.PutUserProfileStep;
import org.hive2hive.core.processes.register.UserProfileCreationStep;
import org.hive2hive.core.processes.share.PrepareNotificationsStep;
import org.hive2hive.core.processes.share.UpdateUserProfileStep;
import org.hive2hive.core.processes.share.VerifyFriendIdStep;
import org.hive2hive.core.processes.userprofiletask.HandleUserProfileTaskStep;
import org.hive2hive.core.security.UserCredentials;
import org.hive2hive.processframework.composites.SyncProcess;
import org.hive2hive.processframework.decorators.AsyncComponent;
import org.hive2hive.processframework.interfaces.IProcessComponent;

/**
 * Factory class for the creation of specific process components and composites that represent basic
 * operations of the Hive2Hive project.
 * 
 * @author Christian, Nico, Seppi
 */
public final class ProcessFactory {

	private static ProcessFactory instance;

	private ProcessFactory() {
		// singleton
	}

	public static ProcessFactory instance() {
		if (instance == null) {
			instance = new ProcessFactory();
		}
		return instance;
	}

	/**
	 * Creates and returns a registration process.
	 * 
	 * @param credentials The credentials of the user to be registered.
	 * @param networkManager The network manager / node on which the registration operations should be
	 *            executed.
	 * @return A registration process.
	 * @throws NoPeerConnectionException If the peer is not connected to the network.
	 */
	public IProcessComponent<Void> createRegisterProcess(UserCredentials credentials, NetworkManager networkManager)
			throws NoPeerConnectionException {

		DataManager dataManager = networkManager.getDataManager();
		RegisterProcessContext context = new RegisterProcessContext(credentials);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new CheckIsUserRegisteredStep(context, dataManager));
		process.add(new UserProfileCreationStep(context, networkManager.getEncryption()));
		process.add(new AsyncComponent<>(new PutUserProfileStep(context, dataManager)));
		process.add(new AsyncComponent<>(new org.hive2hive.core.processes.register.PutLocationsStep(context, dataManager)));
		process.add(new AsyncComponent<>(new PutPublicKeyStep(context, dataManager)));

		process.setName("Register Process");
		return process;
	}

	/**
	 * Creates and returns a login process.
	 * 
	 * @param credentials The credentials of the user to be logged in.
	 * @param params The session parameters that shall be used.
	 * @param networkManager The network manager / node on which the login operations should be executed.
	 * @return A login process.
	 * @throws NoPeerConnectionException If the peer is not connected to the network.
	 */
	public IProcessComponent<Void> createLoginProcess(UserCredentials credentials, SessionParameters params,
			NetworkManager networkManager) throws NoPeerConnectionException {

		LoginProcessContext context = new LoginProcessContext(credentials, params);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new SessionCreationStep(context, networkManager));
		process.add(new GetLocationsStep(context, networkManager));
		process.add(new ContactOtherClientsStep(context, networkManager));
		process.add(new org.hive2hive.core.processes.login.PutLocationsStep(context, networkManager));

		process.setName("Login Process");
		return process;
	}

	public IProcessComponent<Void> createUserProfileTaskProcess(NetworkManager networkManager) {
		UserProfileTaskContext context = new UserProfileTaskContext();

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new GetUserProfileTaskStep(context, networkManager));
		// Note: this step will add the next steps since it depends on the get result
		process.add(new HandleUserProfileTaskStep(context, networkManager));

		process.setName("User Profile Task Process");
		return process;
	}

	/**
	 * Creates and returns a logout process.
	 * 
	 * @param networkManager The network manager / node on which the logout operations should be executed.
	 * @return A logout process.
	 * @throws NoPeerConnectionException If the peer is not connected to the network.
	 * @throws NoSessionException If the peer is not connected to the network.
	 */
	public IProcessComponent<Void> createLogoutProcess(NetworkManager networkManager) throws NoPeerConnectionException,
			NoSessionException {

		H2HSession session = networkManager.getSession();

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new RemoveOwnLocationsStep(networkManager));
		process.add(new StopDownloadsStep(session.getDownloadManager()));
		process.add(new StopUserQueueWorkerStep(session.getProfileManager()));
		process.add(new WritePersistentStep(session.getFileAgent(), session.getKeyManager(), networkManager.getDataManager()
				.getSerializer()));
		process.add(new DeleteSessionStep(networkManager));

		process.setName("Logout Process");
		return process;
	}

	/**
	 * Process to create a new file. Note that this is only applicable for a single file, not a whole file
	 * tree.
	 * 
	 * @param file
	 * @param networkManager
	 * @param fileConfiguration
	 * @return the process component
	 * @throws NoPeerConnectionException If the peer is not connected to the network.
	 * @throws NoSessionException If no user has logged in.
	 */
	public IProcessComponent<Void> createAddFileProcess(File file, NetworkManager networkManager,
			IFileConfiguration fileConfiguration) throws NoPeerConnectionException, NoSessionException {
		if (file == null) {
			throw new IllegalArgumentException("File can't be null.");
		}
		H2HSession session = networkManager.getSession();
		DataManager dataManager = networkManager.getDataManager();
		AddFileProcessContext context = new AddFileProcessContext(file, session, fileConfiguration,
				networkManager.getEncryption());

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new ValidateFileStep(context));
		process.add(new CheckWriteAccessStep(context, session.getProfileManager()));
		process.add(new CreateFileKeysStep(context));
		if (file.isFile()) {
			// file needs to upload the chunks and a meta file
			process.add(new InitializeChunksStep(context, dataManager));
			process.add(new CreateMetaFileStep(context));
			process.add(new PutMetaFileStep(context, dataManager));
		}
		process.add(new AddIndexToUserProfileStep(context, session.getProfileManager()));
		process.add(new PrepareAddNotificationStep(context));
		process.add(createNotificationProcess(context, networkManager));

		process.setName("New File Process");
		return process;
	}

	public IProcessComponent<Void> createUpdateFileProcess(File file, NetworkManager networkManager,
			IFileConfiguration fileConfiguration) throws NoPeerConnectionException, NoSessionException {
		DataManager dataManager = networkManager.getDataManager();
		H2HSession session = networkManager.getSession();
		UpdateFileProcessContext context = new UpdateFileProcessContext(file, session, fileConfiguration,
				networkManager.getEncryption());

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new ValidateFileStep(context));
		process.add(new CheckWriteAccessStep(context, session.getProfileManager()));
		process.add(new GetFileKeysStep(context, session));
		process.add(new GetMetaFileStep(context, dataManager));
		process.add(new InitializeChunksStep(context, dataManager));
		process.add(new CreateNewVersionStep(context));
		process.add(new PutMetaFileStep(context, dataManager));
		process.add(new UpdateMD5inUserProfileStep(context, session.getProfileManager()));
		// TODO: cleanup can be made async because user operation does not depend on it
		process.add(new CleanupChunksStep(context, dataManager));
		process.add(new PrepareUpdateNotificationStep(context));
		process.add(createNotificationProcess(context, networkManager));

		process.setName("Update File Process");
		return process;
	}

	/**
	 * Process for downloading the newest version to the default location.
	 */
	public IProcessComponent<Void> createDownloadFileProcess(File file, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		return createDownloadFileProcess(null, file, DownloadFileContext.NEWEST_VERSION_INDEX, null, networkManager);
	}

	/**
	 * Process for downloading the newest version to the default location.
	 */
	public IProcessComponent<Void> createDownloadFileProcess(PublicKey fileKey, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		return createDownloadFileProcess(fileKey, null, DownloadFileContext.NEWEST_VERSION_INDEX, null, networkManager);
	}

	/**
	 * Process for downloading with some extra parameters. This can for example be used to restore a file. The
	 * version and the filename are only effective for files, not for folders.
	 */
	public IProcessComponent<Void> createDownloadFileProcess(PublicKey fileKey, int versionToDownload, File destination,
			NetworkManager networkManager) throws NoPeerConnectionException, NoSessionException {

		return createDownloadFileProcess(fileKey, null, versionToDownload, destination, networkManager);
	}

	/**
	 * Process for downloading with some extra parameters. This can for example be used to restore a file. The
	 * version and the filename are only effective for files, not for folders. Either give the file key or the
	 * absolute file as argument.
	 */
	public IProcessComponent<Void> createDownloadFileProcess(PublicKey fileKey, File file, int versionToDownload,
			File destination, NetworkManager networkManager) throws NoPeerConnectionException, NoSessionException {

		// precondition: session is existent
		networkManager.getSession();
		DownloadFileContext context = new DownloadFileContext(fileKey, file, destination, versionToDownload);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new FindInUserProfileStep(context, networkManager));

		process.setName("Download File Process");
		return process;
	}

	/**
	 * Deletes the specified file. Note that this is only valid for a single file or an empty folder
	 * (non-recursive)
	 * 
	 * @param file
	 * @param networkManager
	 * @return the process component
	 * @throws NoPeerConnectionException If the peer is not connected to the network.
	 * @throws NoSessionException If no user has logged in.
	 */
	public IProcessComponent<Void> createDeleteFileProcess(File file, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		H2HSession session = networkManager.getSession();

		DeleteFileProcessContext context = new DeleteFileProcessContext(file, session, networkManager.getEncryption());

		// process composition
		SyncProcess process = new SyncProcess();

		// hint: this step automatically adds additional process steps when the meta file and the chunks need
		// to be deleted
		process.add(new DeleteFromUserProfileStep(context, networkManager));
		process.add(new PrepareDeleteNotificationStep(context));
		process.add(createNotificationProcess(context, networkManager));

		process.setName("Delete File Process");
		return process;
	}

	public IProcessComponent<Void> createMoveFileProcess(File source, File destination, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		H2HSession session = networkManager.getSession();
		MoveFileProcessContext context = new MoveFileProcessContext(source, destination, session.getRootFile());

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new org.hive2hive.core.processes.files.move.CheckWriteAccessStep(context, session.getProfileManager()));
		process.add(new RelinkUserProfileStep(context, session.getProfileManager(), networkManager.getDataManager()));
		process.add(createNotificationProcess(context.getMoveNotificationContext(), networkManager));
		process.add(createNotificationProcess(context.getDeleteNotificationContext(), networkManager));
		process.add(createNotificationProcess(context.getAddNotificationContext(), networkManager));

		process.setName("Move File Process");
		return process;
	}

	public IProcessComponent<Void> createRecoverFileProcess(File file, IVersionSelector selector,
			NetworkManager networkManager) throws NoPeerConnectionException, NoSessionException, IllegalArgumentException {

		RecoverFileContext context = new RecoverFileContext(file);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new GetFileKeysStep(context, networkManager.getSession()));
		process.add(new GetMetaFileStep(context, networkManager.getDataManager()));
		process.add(new SelectVersionStep(context, selector, networkManager));

		process.setName("Recover File Process");
		return process;
	}

	public IProcessComponent<Void> createShareProcess(File folder, UserPermission permission, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		ShareProcessContext context = new ShareProcessContext(folder, permission);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new VerifyFriendIdStep(networkManager.getSession().getKeyManager(), permission.getUserId()));
		process.add(new UpdateUserProfileStep(context, networkManager.getSession(), networkManager.getEncryption()));
		process.add(new InitializeMetaUpdateStep(context, networkManager.getDataManager()));
		process.add(new PrepareNotificationsStep(context, networkManager.getUserId(), networkManager.getEncryption()));
		process.add(createNotificationProcess(context, networkManager));

		process.setName("Share Process");
		return process;
	}

	// public ProcessComponent createUnshareProcess(File folder, NetworkManager networkManager)
	// throws NoPeerConnectionException, NoSessionException {
	// UnshareProcessContext context = new UnshareProcessContext(folder);
	//
	// SequentialProcess process = new SequentialProcess();
	// process.add(new CheckSharedFolderStep(context, networkManager.getSession()));
	// process.add(createNotificationProcess(context, networkManager));
	// return process;
	// }

	/**
	 * Creates and returns a file list process.
	 * 
	 * @param networkManager The network manager / node on which the file list operations should be executed.
	 * @return A file list process.
	 * @throws NoSessionException
	 */
	public IProcessComponent<FileNode> createFileListProcess(NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {
		H2HSession session = networkManager.getSession();

		// only one process step
		IProcessComponent<FileNode> step = new GetFileListStep(session.getProfileManager(), session.getRootFile());

		step.setName("File List Process");
		return step;
	}

	public IProcessComponent<Void> createNotificationProcess(final BaseNotificationMessageFactory messageFactory,
			final Set<String> usersToNotify, NetworkManager networkManager) throws NoPeerConnectionException,
			NoSessionException {

		// create a context here to provide the necessary data
		INotifyContext context = new INotifyContext() {

			@Override
			public Set<String> consumeUsersToNotify() {
				return usersToNotify;
			}

			@Override
			public BaseNotificationMessageFactory consumeMessageFactory() {
				return messageFactory;
			}
		};
		return createNotificationProcess(context, networkManager);
	}

	private IProcessComponent<Void> createNotificationProcess(INotifyContext providerContext, NetworkManager networkManager)
			throws NoPeerConnectionException, NoSessionException {

		NotifyProcessContext context = new NotifyProcessContext(providerContext);

		// process composition
		SyncProcess process = new SyncProcess();

		process.add(new VerifyNotificationFactoryStep(context, networkManager.getUserId()));
		process.add(new GetPublicKeysStep(context, networkManager.getSession().getKeyManager()));
		process.add(new PutAllUserProfileTasksStep(context, networkManager));
		process.add(new GetAllLocationsStep(context, networkManager.getDataManager()));
		process.add(new SendNotificationsMessageStep(context, networkManager));

		process.setName("Notification Process");
		return process;
	}
}
