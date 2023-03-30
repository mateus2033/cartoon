<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    private User $userModel;
    private UserService $userService;

    public function __construct(UserService $userService, User $userModel)
    {
        $this->userModel   = $userModel;
        $this->userService = $userService;
    }


    public function listUser(Request $request)
    {
        $users = $this->userService->index($request);
        return response()->json($users, Response::HTTP_OK);
    }

    public function storage(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->only($this->userModel->getModel()->getFillable());
            $user = $this->userService->manageStorageUser($user);
            if ($user instanceof User) {
                return response()->json($this->responseUser($user), Response::HTTP_CREATED);
            }
            return response()->json($user, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        try {
            $user = (int) $request->user_id;
            $user = $this->userService->showUserById($user);
            $response = new UserResource($user);
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->only($this->userModel->getModel()->getFillable());
            $user = $this->userService->manageUpdateUser($user);
            if ($user instanceof User) {
                return response()->json($this->responseUser($user), Response::HTTP_CREATED);
            }
            return response()->json($user, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = (int) $request->user_id;
            $user = $this->userService->manageDestroyUser($user);
            DB::commit();
            return response()->json(SuccessMessage::sucessMessage(ConstantMessage::OPERATION_SUCCESSFULLY), Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function updatePicture(Request $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->userService->manageUpdatePhotoPerfil((int) $request->id, $request->file());
            if (is_array($response)) {
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            DB::commit();
            return response()->json(SuccessMessage::sucessMessage($response), Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function removePhotoPerfil(Request $request)
    {
        $response = $this->userService->removePhotoPerfil((int) $request->id);
        return response()->json($response, Response::HTTP_OK);
    }

    private function responseUser(User $user)
    {
        DB::commit();
        $user = new UserResource($user);
        return $user;
    }
}
