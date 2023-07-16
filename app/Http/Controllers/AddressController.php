<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Utils\ErroMensage\ErroMensage;
use App\Services\Address\AddressService;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressUserResource;

class AddressController extends Controller
{

    private Address $addressModel;
    private AddressService $addressService;

    public function __construct(
        Address $addressModel,
        AddressService $addressService
    ){
        $this->addressModel   = $addressModel;
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        $user_id  = auth('api')->user()->id;
        $response = $this->addressService->listAddress($user_id);
        if(!is_array($response))
        {
            return response()->json(new AddressUserResource($response), Response::HTTP_OK);
        }
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }

    /**
     * @OA\Post(
     *     tags={"Address"},
     *     path="/api/address/storage",
     *     summary="Armazenar um novo endereço",
     *     description="Armazena um novo endereço no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="street", type="string", example="Rua 99"),
     *             @OA\Property(property="number", type="string",   example="100"),
     *             @OA\Property(property="city",   type="string", example="Valaquia"),
     *             @OA\Property(property="state",  type="string", example="MG"),
     *             @OA\Property(property="postalCode", type="string", example="29111-599"),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Address")
     *
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
        try{
            $address = $request->only($this->addressModel->getModel()->getFillable());
            $address = $this->addressService->manageStorageAddress($address);
            if($address instanceof Address) {
                return response()->json($this->responseAddress($address), Response::HTTP_CREATED);
            }

            return response()->json($address, Response::HTTP_BAD_REQUEST);
        }catch(Exception $e) {
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/address/update",
     *     tags={"Address"},
     *     security={{"bearerAuth":{}}},
     *     summary="Atualizar um usuário",
     *     description="Atualizar um endereço no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="street", type="string", example="Rual Valentia"),
     *             @OA\Property(property="number", type="intger", example="150"),
     *             @OA\Property(property="city", type="string", example="São Benedito"),
     *             @OA\Property(property="state", type="string", example="MG"),
     *             @OA\Property(property="postalCode", type="string", example="29484-898"),
     *             @OA\Property(property="user_id", type="intger", example=1),
     * )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Atualizar endereço",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Address")
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
        try{
            DB::beginTransaction();
            $address = $request->only($this->addressModel->getModel()->getFillable());
            $address = $this->addressService->manageUpdateAddress($address);
            if($address instanceof Address) {
                return response()->json($this->responseAddress($address), Response::HTTP_OK);
            }
            return response()->json($address, Response::HTTP_BAD_REQUEST);
        }catch(Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/address/destroy",
     *     tags={"Address"},
     *     security={{"bearerAuth":{}}},
     *     summary="Deletar o endereço de um usuario",
     *     description="Deletar um endereço no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operation successfully",
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
        try{
            $address_id = (int) $request->id;
            $user_id    = auth('api')->user()->id;
            $response   = $this->addressService->manageDeleteAddress($address_id, $user_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(Exception $e) {
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    private function responseAddress(Address $address)
    {
        DB::commit();
        $address = new AddressResource($address);
        return $address;
    }
}
