<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Resources\Product\ProductGenericResource;
use App\Http\Resources\Product\ProductIndexResource;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller
{
    private Stock $stock;
    private Product $product;
    private ProductService $productService;

    public function __construct(
        ProductService $productService,
        Product $product,
        Stock   $stock
    ) {
        $this->productService = $productService;
        $this->product = $product;
        $this->stock   = $stock;
    }



    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/product/index",
     *     summary="Listar produtos",
     *     description="Retorna uma lista de produtos",
     *     @OA\Response(
     *         response="200",
     *         description="Lista de produtos",
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $response = $this->productService->index($request->paginate);
        if ($response instanceof Collection)
            return response()->json(new ProductIndexResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/cartoon/indexOfProductForUser",
     *     summary="Listar produtos",
     *     description="Retorna uma lista de produtos",
     *     @OA\Response(
     *         response="200",
     *         description="Lista de produtos",
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function indexOfProductForUser(Request $request)
    {
        $response = $this->productService->indexOfProductForUser($request->paginate);
        if ($response instanceof Collection)
            return response()->json(new ProductGenericResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/cartoon/indexMoreSold",
     *     summary="Lista os produtos mais vendidos",
     *     description="Lista os produtos mais vendidos",
     *     @OA\Response(
     *         response="200",
     *         description="Lista de produtos",
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function indexOfMoreSoldInMonth()
    {
        $response = $this->productService->indexOfMoreSoldInMonth();
        if ($response instanceof Collection)
            return response()->json(new ProductGenericResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/product/show",
     *     summary="Get product information",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         required=true,
     *         description="ID of the product to get",
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
     *             @OA\Property(property="id",    type="string", example="59"),
     *             @OA\Property(property="name",  type="string", example="John"),
     *             @OA\Property(property="price", type="float", example="John"),
     *             @OA\Property(property="category", type="object"),
     *             @OA\Property(property="stock",  type="object"),
     *             @OA\Property(property="photos", type="array", @OA\Items(type="array", @OA\Items()))
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
        $product_id = (int) $request->product_id;
        $response = $this->productService->showProductById($product_id);
        if ($response instanceof Product)
            return response()->json(new ProductResource($response), Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_NOT_FOUND);
    }

    /**
     * @OA\Post(
     *     tags={"Products"},
     *     path="/api/product/storage",
     *     summary="Armazenar um novo produto",
     *     description="Armazena um novo produto no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="name",         type="string", example="John"),
     *             @OA\Property(property="price",        type="float",  example="Tereuba"),
     *             @OA\Property(property="category_id",  type="integer", example=1),
     *             @OA\Property(property="stock_min",    type="integer", example=100),
     *             @OA\Property(property="stock_max", type="integer",    example=100),
     *             @OA\Property(property="image[0]",   type="string",format="binary"),
     *             @OA\Property(property="image[1]",   type="string",format="binary"),
     *             @OA\Property(property="image[2]",   type="string",format="binary"),
     *             @OA\Property(property="image[3]",   type="string",format="binary"),
     *        ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
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
            $product = $request->only($this->product->getModel()->getFillable());
            $stock   = $request->only($this->stock->getModel()->getFillable());
            $response = $this->productService->manageStorageProduct($product, $stock, (array) $request->image);
            if ($response instanceof Product) {
                DB::commit();
                return response()->json(new ProductResource($response), Response::HTTP_CREATED);
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/product/update",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     summary="Atualizar um produto",
     *     description="Atualizar um novo produto no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id",    type="integer", example=1),
     *             @OA\Property(property="name",  type="string", example="Agenda"),
     *             @OA\Property(property="price", type="string", example="Tereuba"),
     *             @OA\Property(property="category_id",   type="string", example=1),
     *             @OA\Property(property="stock_min",     type="string", example=100),
     *             @OA\Property(property="stock_max",     type="string", example=100),
     *             @OA\Property(property="stock_current", type="string", example=100),
     *      ),
     *          ),
     *     @OA\Response(
     *         response="201",
     *         description="Atualizado criado com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
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
            $product = $request->only($this->product->getModel()->getFillable());
            $stock   = $request->only($this->stock->getModel()->getFillable());
            $response = $this->productService->manageUpdateProduct($product, $stock);
            if ($response instanceof Product) {
                DB::commit();
                return response()->json(new ProductResource($response), Response::HTTP_OK);
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/product/destroy",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     summary="Deletar um usuário",
     *     description="Atualizar um novo usuário no sistema.",
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
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
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
            $product_id = (int) $request->id;
            $response = $this->productService->destroy($product_id);
            if (is_bool($response)) {
                DB::commit();
                return response()->json(SuccessMessage::sucessMessage(ConstantMessage::OPERATION_SUCCESSFULLY), Response::HTTP_OK);
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }
}
