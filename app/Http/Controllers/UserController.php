<?php

namespace App\Http\Controllers;


use OpenApi\Annotations as OA;
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

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/user/listUser",
     *     summary="Listar usuários",
     *     description="Retorna uma lista de usuários",
     *     @OA\Response(
     *         response="200",
     *         description="Lista de usuários",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function listUser(Request $request)
    {
        $users = $this->userService->index($request);
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     tags={"Session"},
     *     path="/api/account/storage",
     *     summary="Armazenar um novo usuário",
     *     description="Armazena um novo usuário no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Tereuba"),
     *             @OA\Property(property="image", type="string", example="email@email.com"),
     *             @OA\Property(property="cpf", type="string", example="999.888.777.66"),
     *             @OA\Property(property="dataBirth", type="string", example="01-01-1685"),
     *             @OA\Property(property="cellphone", type="string", example="(27)9999-7777"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="secret"),
     * )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Ocorreu um erro interno no servidor.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/user/show",
     *     summary="Get user information",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         description="ID of the user to get",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns user information",
     *          @OA\JsonContent(
     *             @OA\Property(property="id",        type="string", example="59"),
     *             @OA\Property(property="name",      type="string", example="John"),
     *             @OA\Property(property="lastName",  type="string", example="Test"),
     *             @OA\Property(property="cpf",       type="string", example="979.508.820-34"),
     *             @OA\Property(property="dataBirth", type="string", example="1895-05-05"),
     *             @OA\Property(property="cellphone", type="string", example="279999-9999"),
     *             @OA\Property(property="image",     type="string", example="d043b2065e9ecf6d152a878703b364cc.jpg"),
     *             @OA\Property(property="email",     type="string", example="email@email.com"),
     *             @OA\Property(property="address",   type="array[]"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not found"),
     *         ),
     *     ),
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/user/update",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     summary="Atualizar um usuário",
     *     description="Atualizar um novo usuário no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Tereuba"),
     *             @OA\Property(property="cpf", type="string", example="999.888.777.66"),
     *             @OA\Property(property="dataBirth", type="string", example="01-01-1685"),
     *             @OA\Property(property="cellphone", type="string", example="(27)9999-7777"),
     * )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Atualizado criado com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token sem autorização."))
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Erro de validação."))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Erro interno no servidor."))
     *     ),
     *  ),
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/user/destroy",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     summary="Deletar um usuário",
     *     description="Atualizar um novo usuário no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operation successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token sem autorização."))
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Usuario não encontrado."))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Erro interno no servidor."))
     *     ),
     *  ),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/user/updatePhotoPerfil",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     summary="Atualizar foto do perfil",
     *     description="Atualizar foto do perfil de usuário.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="id",description="id do usuario",type="integer"),
     *                 @OA\Property(property="image",description="File to be uploaded",type="string",format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operation successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token sem autorização."))
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Usuario não encontrado."))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Erro interno no servidor."))
     *     ),
     *  ),
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/user/removePhoto",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     summary="Remover foto do perfil",
     *     description="Remover foto do perfil de usuário.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operation successfully",
     *             @OA\JsonContent(@OA\Property(property="error", type="string", example="Operation successfully."))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token sem autorização."))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o usuário",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Erro interno no servidor."))
     *     ),
     *  ),
     * )
     */
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
