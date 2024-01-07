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


    public function index(Request $request)
    {  
        $response = $this->productService->index($request->all());
        if (!is_array($response) && !$response->isEmpty())
            return response()->json(new ProductIndexResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function indexOfProductForUser(Request $request)
    {   
        $response = $this->productService->indexOfProductForUser($request->all());
        if (!is_array($response) && !$response->isEmpty())
            return response()->json(new ProductGenericResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function indexOfMoreSoldInMonth(Request $request)
    {
        $response = $this->productService->indexOfMoreSoldInMonth($request->all());
        if (!is_array($response) && !$response->isEmpty())
            return response()->json(new ProductGenericResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function show(Request $request)
    {
        $product_id = (int) $request->id;
        $response = $this->productService->showProductById($product_id);
        if ($response instanceof Product)
            return response()->json(new ProductResource($response), Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_NOT_FOUND);
    }

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
