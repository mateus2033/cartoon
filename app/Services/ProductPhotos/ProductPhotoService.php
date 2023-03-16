<?php

namespace App\Services\ProductPhotos;

use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class ProductPhotoService  {

    private ProductPhotoValidationForSaveService $productPhotoValidationForSaveService;

    public function __construct(ProductPhotoValidationForSaveService $productPhotoValidationForSaveService)
    {
        $this->productPhotoValidationForSaveService = $productPhotoValidationForSaveService;
    }

    public function manageStorageProductPhotos(array $images, int $product_id)
    {
        $error = [];
        if(count($images) != 4)
        {
            return ErroMensage::errorMessage(ConstantMessage::INVALID_NUMBER_PHOTOS);
        }

        for($i = 0; $i < count($images); $i++)  {
           $array[] = $this->productPhotoValidationForSaveService->validFormProductPhoto($images[$i], $product_id);
           if(!is_array($array)){
                $error[] = $array;
           }
        }



        dd($array, 'ProductPhotoService');



    }

}
