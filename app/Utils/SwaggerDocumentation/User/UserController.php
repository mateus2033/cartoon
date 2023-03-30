<?php

namespace App\Utils\SwaggerDocumentation\User;

class UserController
{

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
    public function listUser()
    {
        //
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
    public function storage()
    {
        //
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
    public function show()
    {
        //
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
    public function update()
    {
        //
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
    public function destroy()
    {
        //
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
    public function updatePicture()
    {
        //
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
    public function removePhotoPerfil()
    {
        //
    }
}
