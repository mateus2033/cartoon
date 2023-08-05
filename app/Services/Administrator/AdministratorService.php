<?php

namespace App\Services\Administrator;

use App\Models\User;
use App\Utils\LogsInfo\MessageLog;
use App\Utils\LogsInfo\OriginLog;
use Illuminate\Support\Facades\Log;
use App\Utils\ManagePath\ManagePath;
use App\Utils\ConstantMessage\ConstantPath;
use App\Repository\User\UserRepository;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\PermissionValue\PermissionValue;
use App\Interfaces\Administrator\AdministratorServiceInterface;

class AdministratorService implements AdministratorServiceInterface
{

    private UserRepository $userRepository;
    private AdministratorValidationForSaveService $administratorValidationForSaveService;
    private AdministratorValidationForUpdateService $administratorValidationForUpdateService;
    private UserValidationPhotoPerfilForUpdate $userValidationPhotoPerfilForUpdate;

    public function __construct(
        UserRepository $userRepository,
        AdministratorValidationForSaveService $administratorValidationForSaveService,
        AdministratorValidationForUpdateService $administratorValidationForUpdateService,
        UserValidationPhotoPerfilForUpdate $userValidationPhotoPerfilForUpdate
    ) {
        $this->userRepository = $userRepository;
        $this->administratorValidationForSaveService = $administratorValidationForSaveService;
        $this->administratorValidationForUpdateService = $administratorValidationForUpdateService;
        $this->userValidationPhotoPerfilForUpdate = $userValidationPhotoPerfilForUpdate;
    }

    public function manageSaveUserAdministrator(array $data)
    {
        $administrator = $this->administratorValidationForSaveService->validateFormAdministrator($data);
        if (is_array($administrator)) {
            $user = $this->userRepository->create($administrator);
            Log::channel('adm')->debug(OriginLog::ADM_SERVICE_CREATE,[MessageLog::ADM_SAVED, $user->cpf]);
            return $user;
        }

        if (!empty($administrator->fileName)) {
            unlink(public_path(ConstantPath::PERFIL_PATH_ADM . $administrator->fileName));
        }
        return $administrator->message;
    }

    public function showUserAdministrator()
    {
        $administrator = $this->userRepository->findById(auth('api')->user()->id);
        if (!is_null($administrator) && $administrator->rule_id == PermissionValue::ADMIN_PERMISSION)
            return $administrator;
        else
            return ErroMensage::errorMessage(ConstantMessage::USERNOTFOUND);
    }

    public function manageUpdateUserAdministrator(array $data)
    {
        $administrator = $this->administratorValidationForUpdateService->validateFormAdministrator($data);
        if (!is_array($administrator)) {
            return $administrator->message;
        }

        $getAdm = $this->showUserAdministrator($data['id']);
        if (is_array($getAdm)) {
            return $getAdm;
        }

        $this->userRepository->update($getAdm, $administrator);
        Log::channel('adm')->debug(OriginLog::ADM_SERVICE_CREATE,[MessageLog::ADM_UPDATED, $getAdm->cpf]);
        return $getAdm;
    }

    public function manageDeleteUserAdministrator(int $adm_id)
    {
        $administrator = $this->showUserAdministrator($adm_id);
        if (is_array($administrator)) {
            return $administrator;
        }

        $this->preprareToRemovePath($administrator);
        $this->userRepository->destroy($administrator->id);
        Log::channel('adm')->debug(OriginLog::ADM_SERVICE_DELETE,[MessageLog::ADM_DELETED, $administrator->cpf]);
        return ConstantMessage::OPERATION_SUCCESSFULLY;
    }

    public function manageUpdatePhotoPerfil(int $id, array $image)
    {
        $administrator = $this->showUserAdministrator($id);
        if (is_array($administrator)) {
            return $administrator;
        }

        $image = $this->userValidationPhotoPerfilForUpdate->validPhotoPerfil($image);
        if (is_string($image)) {
            return ErroMensage::errorMessage($image);
        }

        $this->preprareToRemovePath($administrator);
        $this->updatePhotoPerfil($administrator, $image);
        return $administrator;
    }

    public function updatePhotoPerfil(User $user, $image)
    {
        $savePhoto = ManagePath::createPath(ConstantPath::PERFIL_PATH_ADM, $image);
        $this->userRepository->update($user, ['image' => $savePhoto]);
        return true;
    }

    public function preprareToRemovePath(User $administrator): void
    {
        if (!is_null($administrator->image) && file_exists(public_path(ConstantPath::PERFIL_PATH_ADM . $administrator->image))) {
            unlink(public_path(ConstantPath::PERFIL_PATH_ADM . $administrator->image));
        }
    }
}
