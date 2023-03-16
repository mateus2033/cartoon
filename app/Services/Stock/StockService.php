<?php

namespace App\Services\Stock;

use App\Interfaces\Stock\StockServiceInterface;
use App\Models\Product;
use App\Models\Stock;
use App\Repository\Stock\StockRepository;

class StockService implements StockServiceInterface {

    private StockRepository $stockRespository;
    private StockValidationForSaveService $stockValidationForSaveService;
    private StockValidationForUpdateService $stockValidationForUpdateService;

    public function __construct(
        StockRepository $stockRespository, 
        StockValidationForSaveService $stockValidationForSaveService, 
        StockValidationForUpdateService $stockValidationForUpdateService
    ){
        $this->stockRespository = $stockRespository;
        $this->stockValidationForSaveService   = $stockValidationForSaveService;
        $this->stockValidationForUpdateService = $stockValidationForUpdateService;
    }

    public function manageStorageStock(array $stock, int $product_id)
    {
        $stock = $this->stockValidationForSaveService->validFormStock($stock, $product_id);
        if(is_array($stock))
        {
            $this->stockRespository->create($stock);
            return true;
        }
        return $stock->message;
    }

    public function manageUpdateStock(Product $product, array $stock)
    {
        $stock = $this->stockValidationForUpdateService->validFormStock($stock);
        if(is_array($stock))
        {
            $this->stockRespository->update($product->stock,$stock);
            return true;
        }
        return $stock->message;
    }

    public function destroyStockRelation($stock)
    {   
        if(!is_null($stock)){
            $this->stockRespository->destroy($stock->id);
            return true;
        }
        return true;
    }
}