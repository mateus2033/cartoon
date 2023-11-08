<?php

namespace App\Services\Product;

use App\Interfaces\Product\ProductServiceInterface;
use App\Repository\Product\ProductRepository;
use App\Services\Acquisitions\AcquisitionsService;
use App\Services\ProductPhotos\ProductPhotoService;
use App\Services\Stock\StockService;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;
use DateInterval;
use DateTime;

class ProductService implements ProductServiceInterface {

    private StockService $stockService;
    private ProductRepository $productRepository;
    private ProductPhotoService $productPhotoService;
    private ProductValidationForSaveService $productValidationForSaveService;
    private AcquisitionsService $acquisitionsService;
    private ProductValidationForUpdateService $productValidationForUpdateService;

    public function __construct(
        StockService $stockService,
        ProductRepository $productRepository,
        AcquisitionsService $acquisitionsService,
        ProductPhotoService $productPhotoService,
        ProductValidationForSaveService $productValidationForSaveService,
        ProductValidationForUpdateService $productValidationForUpdateService
    ){
        $this->stockService = $stockService;
        $this->productRepository = $productRepository;
        $this->productPhotoService = $productPhotoService;
        $this->acquisitionsService = $acquisitionsService;
        $this->productValidationForSaveService = $productValidationForSaveService;
        $this->productValidationForUpdateService = $productValidationForUpdateService;
    }

    public function index($paginate)
    {
        $response = $this->productRepository->getAll();
        if(!$response->isEmpty())
            return $response;
        else
        return SuccessMessage::sucessMessage(ConstantMessage::LIST_PRODUCT_EMPTY);
    }

    public function indexOfProductForUser($paginate)
    {
        $response = $this->productRepository->getAll();
        if(!$response->isEmpty())
            return $response;
        else
        return SuccessMessage::sucessMessage(ConstantMessage::LIST_PRODUCT_EMPTY);
    }

    public function indexOfMoreSoldInMonth()
    {
        $productMoreSold = $this->getProductMoreSold();
        if(!$productMoreSold->isEmpty())
            return $productMoreSold;
        else
        return ErroMensage::errorMessage(ConstantMessage::PRODUCT_NOT_FOUND);
    }

    public function getProductMoreSold()
    {
        $dateNow = date('Y-m-d');
        $date = new DateTime($dateNow);
        $interval = new DateInterval('P6M');
        $date->sub($interval);
        $dateInitial = $date->format('Y-m-d');

        $products = $this->productRepository->getAll()->load('acquisitions');
        $response = $products
                    ->whereBetween('acquisitions.period',[$dateInitial,$dateNow])
                    ->sortByDesc('acquisitions.amount');
        return $response;
    }

    public function manageStorageProduct(array $product, array $stock, array $photos)
    {
        $product = $this->productValidationForSaveService->validFormProduct($product);
        if(!is_array($product))
        {
            return ErroMensage::errorMultipleMessage($product->message);
        }

        $product = $this->productRepository->create($product);
        $stock   = $this->stockService->manageStorageStock($stock, $product->id);
        if(!is_bool($stock))
        {
           return $stock;
        }
       
        $photos = $this->productPhotoService->manageStorageProductPhotos($photos, $product);
        if(is_array($photos))
        {
            return $photos;
        }

        return $this->showProductById($product->id);
    }

    public function showProductById(int $product_id)
    {
        $product = $this->productRepository->findById($product_id);
        if(!is_null($product))
            return $product;
        else
        return ErroMensage::errorMessage(ConstantMessage::PRODUCT_NOT_FOUND);
    }

    public function manageUpdateProduct(array $product, array $stock)
    {
        $productValid = $this->productValidationForUpdateService->validFormProduct($product);
        if(!is_array($productValid))
        {
            return ErroMensage::errorMultipleMessage($productValid->message);
        }

        $product = $this->showProductById($productValid['id']);
        if(is_array($product))
        {
            return $product;
        }

        $this->productRepository->update($product, $productValid);
        $stock = $this->stockService->manageUpdateStock($product, $stock);
        if(is_array($stock))
        {
            return ErroMensage::errorMultipleMessage($stock);
        }
        return $product;
    }

    public function destroy(int $product_id)
    {
        $product = $this->showProductById($product_id);
        if(is_array($product))
        {
            return ErroMensage::errorMultipleMessage($product);
        }

        $this->stockService->destroyStockRelation($product->stock);
        $this->acquisitionsService->destroyAcquisitionRelation($product->acquisitions);
        $this->productRepository->destroy($product->id);
        return true;
    }
}
