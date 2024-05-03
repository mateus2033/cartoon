<?php

namespace App\Services\ProductPhotos;

use App\Interfaces\ProductPhotos\ProductPhotoServiceInterface;
use App\Interfaces\ProductPhotos\ProductPhotosRepositoryInterface;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class ProductPhotoService implements ProductPhotoServiceInterface
{

    private ProductPhotosRepositoryInterface $productPhotosRepository;
    private ProductPhotoValidationForSaveService $productPhotoValidationForSaveService;

    public function __construct(
        ProductPhotosRepositoryInterface $productPhotosRepository,
        ProductPhotoValidationForSaveService $productPhotoValidationForSaveService
    ) {
        $this->productPhotosRepository = $productPhotosRepository;
        $this->productPhotoValidationForSaveService = $productPhotoValidationForSaveService;
    }

    public function manageStorageProductPhotos(array $images,  $product)
    {   
        $error = [];
        if (count($images) != 4) {
            return ErroMensage::errorMessage(ConstantMessage::INVALID_NUMBER_PHOTOS);
        }

        for ($i = 0; $i < count($images); $i++) {
            $array[] = $this->productPhotoValidationForSaveService->validFormProductPhoto($images[$i], $product->id);
            if (!is_array($array)) {
                $error[] = $array;
            }
        }

        if (count($error) > 0) {
            return $error;
        }

        return $this->saveProductPhotos($array);
    }

    private function saveProductPhotos(array $photos)
    {   
        foreach ($photos as $photo) {
            $this->productPhotosRepository->create($photo);
        }
        return true;
    }
}
