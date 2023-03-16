<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\ErroMensage\ErroMensage;
use App\Repository\User\UserRepository;
use App\Interfaces\User\UserServiceInterface;
use App\Repository\Address\AddressRepository;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\ConstantPath;
use App\Utils\ManagePath\ManagePath;
use App\Utils\SuccessMessage\SuccessMessage;
use Exception;

class UserService implements UserServiceInterface
{

    private UserRepository $userRepository;
    private AddressRepository $addressRepository;
    private UserValidationForSaveService $userValidationForSaveService;
    private UserValidationForUpdateService $userValidationForUpdateService;
    private UserValidationPhotoPerfilForUpdate $userValidationPhotoPerfilForUpdate;

    public function __construct(
        UserRepository $userRepository,
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
        $response = [];
        $users = $this->userRepository->getAll();

        foreach ($users as $user) {
            $user->load('address');
            $response[] = $user;
        }
        return $response;
    }

    public function manageStorageUser(array $data)
    {
        $user = $this->userValidationForSaveService->validateFormUser($data);
        if (is_array($user)) {
            $user = $this->userRepository->create($user);
            return $user;
        }

        if (!empty($user->fileName)) {
            unlink(public_path(ConstantPath::PERFIL_PATH . $user->fileName));
        }
        return $user->message;
    }

    public function showUserById(int $user_id)
    {
        $user = $this->userRepository->findById($user_id);
        if (!is_null($user)) {
            return $user;
        }
        throw new Exception(ConstantMessage::USERNOTFOUND, 404);
    }

    public function getUserById(int $user_id)
    {
        $user = $this->userRepository->findById($user_id);
        if (!is_null($user)) {
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
            return $user;
        }
    }

    public function manageDestroyUser(int $user_id)
    {
        $user = $this->showUserById($user_id);
        $this->destroyUserAddress($user->load('address'));
        $this->userRepository->destroy($user->id);
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
