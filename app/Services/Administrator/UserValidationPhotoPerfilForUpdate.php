<?php

namespace App\Services\Administrator;

use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class UserValidationPhotoPerfilForUpdate
{

    public function validPhotoPerfil(array $file)
    {
        if(count($file) == 0)
        {
           return ErroMensage::errorMessage(ConstantMessage::REQUIRED);
        }
        
        if(!$file['image']->isValid())
        {
            return  ErroMensage::errorMessage(ConstantMessage::INVALID_IMAGE_PERFIL);    
        }

        return $file['image'];
    }
}
