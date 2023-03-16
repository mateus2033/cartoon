<?php

namespace App\Services\ProductPhotos;

use App\Models\ProductPhoto;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\ConstantPath;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\ManagePath\ManagePath;

class ProductPhotoValidationForSaveService extends ProductPhoto {
    
    private bool  $isValid;
    public  array $message;

    public function validFormProductPhoto($images, int $product_id)
    {   
        $this->validateProductPhoto($images, $product_id);
        if ($this->isValid == true) {
            return $this->mountProductPhoto();
        }
        return $this;
    }

    public function mountProductPhoto(): array
    {
        return [
            'image'    => $this->getImage(),
            'product_id' => $this->getProduct_id()
        ];
    }

    private function validateProductPhoto($image, int $product_id)
    {
        $count = 0;
        $array = [];
        $error = [];
       
        $array['image'] = $this->_image($image);
        $array['product_id'] = $this->_product_id($product_id);
        
        foreach ($array as $key => $value) {
            if (!is_null($value)) {
                $error[$key] = $value;
                $count++;
            }
        }

        if ($count > 0) {
            $this->isValid = false;
            $this->message = $error;
        } else {
            $this->isValid = true;
            $this->message = $array;
        }
    }

    /**
     * @param $image
     * @return string|null
     */
    private function _image($image)
    {  
        if (!isset($image)) {
            return ConstantMessage::REQUIRED;
        }
        
        if (!$image->isValid() || !$image->extension() ) {
            return ConstantMessage::INVALID_IMAGE_PERFIL;
        }
        
    
        $imageName = ManagePath::createPath(ConstantPath::PRODUCT_PATH, $image);       
        $this->setImage($imageName);
        return null;
    }

    /**
     * @param int $image
     * @return string|null
     */
    private function _product_id(int $product_id)
    {
        $this->setProduct_id($product_id);
        return null;
    }

}
