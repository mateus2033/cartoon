<?php

namespace App\Services\User;

use App\Exceptions\CustomException;
use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Utils\ErroMensage\ErroMensage;
use App\Interfaces\User\UserServiceInterface;
use App\Jobs\SendEmail;
use App\Repository\Address\AddressRepository;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\ConstantPath;
use App\Utils\LogsInfo\MessageLog;
use App\Utils\LogsInfo\OriginLog;
use App\Utils\ManagePath\ManagePath;
use App\Utils\PermissionValue\PermissionValue;
use App\Utils\SuccessMessage\SuccessMessage;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Response;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;
    private AddressRepository $addressRepository;
    private UserValidationForSaveService $userValidationForSaveService;
    private UserValidationForUpdateService $userValidationForUpdateService;
    private UserValidationPhotoPerfilForUpdate $userValidationPhotoPerfilForUpdate;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AddressRepository $addressRepository,
        UserValidationForSaveService $userValidationForSaveService,
        UserValidationForUpdateService $userValidationForUpdateService,
        UserValidationPhotoPerfilForUpdate $userValidationPhotoPerfilForUpdate
    ) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
        $this->userValidationForSaveService = $userValidationForSaveService;
        $this->userValidationForUpdateService = $userValidationForUpdateService;
        $this->userValidationPhotoPerfilForUpdate = $userValidationPhotoPerfilForUpdate;
    }

    public function index($data)
    {   
        $users = $this->userRepository->getAll($data->page, $data->perpage, $data->paginate);
        if($users->isEmpty()) {
            return CustomException::exception(ConstantMessage::USERNOTFOUND, Response::HTTP_NO_CONTENT);
        }   

        return $users;
    }

    public function manageStorageUser(array $data)
    {
        $user = $this->userValidationForSaveService->validateFormUser($data);
        if (is_array($user)) {
            $user = $this->userRepository->create($user);
            SendEmail::dispatch($user);
            Log::channel('user')->debug(OriginLog::USER_SERVICE_CREATE,[MessageLog::USER_SAVED, $user->cpf]);
            return $user;
        }
         
        if (!empty($user->fileName)) {
            unlink(public_path(ConstantPath::PERFIL_PATH . $user->fileName));
        }
        return $user->message;
    }

    public function showUserById()
    {
        $user = $this->userRepository->findById(auth('api')->user()->id);
        if (!is_null($user) && $user->rule_id == PermissionValue::USER_PERMISSION) {
            return $user;
        }
        throw new Exception(ConstantMessage::USERNOTFOUND, 404);
    }

    public function getUserById(int $user_id)
    {
        $user = $this->userRepository->findById($user_id);
        if (!is_null($user) && $user->rule_id == PermissionValue::USER_PERMISSION) {
            return $user->load('address');
        }
        return false;
    }

    public function manageUpdateUser(array $data)
    {
        $userValid = $this->userValidationForUpdateService->validateFormUser($data);
        if (!is_array($userValid)) {
            $error = $userValid->message;
            return $error;
        }

        $user = $this->showUserById($userValid['id']);
        if ($user) {
            $user->update($userValid);
            Log::channel('user')->debug(OriginLog::USER_SERVICE_UPDATE,[MessageLog::USER_UPDATED, $user->cpf]);
            return $user;
        }
    }

    public function manageDestroyUser(int $user_id)
    {
        $user = $this->showUserById($user_id);
        $this->destroyUserAddress($user->load('address'));
        $this->userRepository->destroy($user->id);
        Log::channel('user')->debug(OriginLog::USER_SERVICE_DELETE,[MessageLog::USER_DELETED, $user->cpf]);
        return true;
    }

    public function destroyUserAddress(User $user)
    {
        $addresses = $user->address;
        if (!$addresses->isEmpty()) {
            foreach ($addresses as $address) {
                $this->addressRepository->destroy($address->id);
            }
        }
        return true;
    }

    public function manageUpdatePhotoPerfil(int $user_id, array $file)
    {
        $user = $this->getUserById($user_id);
        if (is_bool($user)) {
            return ErroMensage::errorMessage(ConstantMessage::USERNOTFOUND);
        }

        $image = $this->userValidationPhotoPerfilForUpdate->validPhotoPerfil($file);
        if (is_array($image)) {
            return $image;
        }

        $this->removeCurrentPath($user);
        $this->updatePhotoPerfil($user, $image);
        return ConstantMessage::OPERATION_SUCCESSFULLY;
    }

    public function removeCurrentPath(User $user)
    {
        if (!empty($user->image)) {
            unlink(public_path(ConstantPath::PERFIL_PATH . $user->image));
            return true;
        }
        return null;
    }

    public function updatePhotoPerfil(User $user, $image)
    {
        $savePhoto = ManagePath::createPath(ConstantPath::PERFIL_PATH, $image);
        $this->userRepository->update($user, ['image' => $savePhoto]);
        return true;
    }

    public function removePhotoPerfil(int $user_id)
    {
        $user = $this->getUserById($user_id);
        if (is_bool($user)) {
            return ErroMensage::errorMessage(ConstantMessage::USERNOTFOUND);
        }

        if (!empty($user->image)) {
            unlink(public_path(ConstantPath::PERFIL_PATH . $user->image));
            $this->userRepository->update($user, ['image' => ""]);
            return SuccessMessage::sucessMessage(ConstantMessage::OPERATION_SUCCESSFULLY);
        }
        return SuccessMessage::sucessMessage(ConstantMessage::OPERATION_SUCCESSFULLY);
    }

}
