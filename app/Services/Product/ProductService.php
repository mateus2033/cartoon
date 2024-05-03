<?php

namespace App\Services\Product;

use App\Interfaces\Product\ProductRepositoryInterface;
use App\Interfaces\Product\ProductServiceInterface;
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
    private ProductRepositoryInterface $productRepository;
    private ProductPhotoService $productPhotoService;
    private ProductValidationForSaveService $productValidationForSaveService;
    private AcquisitionsService $acquisitionsService;
    private ProductValidationForUpdateService $productValidationForUpdateService;
    private ProductValidationForIndex $productValidationForIndex;

    public function __construct(
        StockService $stockService,
        ProductRepositoryInterface $productRepository,
        AcquisitionsService $acquisitionsService,
        ProductPhotoService $productPhotoService,
        ProductValidationForSaveService $productValidationForSaveService,
        ProductValidationForUpdateService $productValidationForUpdateService,
        ProductValidationForIndex $productValidationForIndex
    ){
        $this->stockService = $stockService;
        $this->productRepository = $productRepository;
        $this->productPhotoService = $productPhotoService;
        $this->acquisitionsService = $acquisitionsService;
        $this->productValidationForSaveService = $productValidationForSaveService;
        $this->productValidationForUpdateService = $productValidationForUpdateService;
        $this->productValidationForIndex = $productValidationForIndex;
    }

    public function index(array $data)
    {
        $payload = $this->productValidationForIndex->validateFormIndex($data);
        if(!is_array($payload)) {
            return $payload->message;
        }

        $response = $this->productRepository->getAll(
            $payload['page'], 
            $payload['perpage'], 
            $payload['paginate']
        );

        if(!$response->isEmpty()) {
            return $response;
        }

        return SuccessMessage::sucessMessage(ConstantMessage::LIST_PRODUCT_EMPTY);
    }

    public function indexOfProductForUser(array $data)
    {   
        $payload = $this->productValidationForIndex->validateFormIndex($data);
        if(!is_array($payload)) {
            return $payload->message;
        }

        $response = $this->productRepository->getAll(
            $payload['page'], 
            $payload['perpage'], 
            $payload['paginate']
        );
        
        if(!$response->isEmpty()) {
            return $response;
        }

        return SuccessMessage::sucessMessage(ConstantMessage::LIST_PRODUCT_EMPTY);
    }

    public function indexOfMoreSoldInMonth(array $data)
    {
        $productMoreSold = $this->getProductMoreSold($data);
        if(is_array($productMoreSold) || !$productMoreSold->isEmpty())
            return $productMoreSold;
        else
        return ErroMensage::errorMessage(ConstantMessage::PRODUCT_NOT_FOUND);
    }

    public function getProductMoreSold(array $data)
    {   
        $dateNow = date('Y-m-d');
        $date = new DateTime($dateNow);
        $interval = new DateInterval('P6M');
        $date->sub($interval);
        $dateInitial = $date->format('Y-m-d');
        
        $payload = $this->productValidationForIndex->validateFormIndex($data);
        if(!is_array($payload)) {
            return $payload->message;
        }

        $response = $this->productRepository->getProductMoreSold(
            $payload['page'], 
            $payload['perpage'], 
            $payload['paginate'],
            $dateInitial,
            $dateNow,
        );
        
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
