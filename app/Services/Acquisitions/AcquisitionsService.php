<?php

namespace App\Services\Acquisitions;

use App\Interfaces\Acquisitions\AcquisitionsServiceInterface;
use App\Repository\Acquisitions\AcquisitionsRespository;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class AcquisitionsService implements AcquisitionsServiceInterface {

    private AcquisitionsRespository $acquisitionsRespository;  

    public function __construct(AcquisitionsRespository $acquisitionsRespository)
    {
        $this->acquisitionsRespository = $acquisitionsRespository;
    }

    public function listAcquisitions()
    {
        $acquisitions = $this->acquisitionsRespository->getAll();
        if(!is_null($acquisitions)) {
            return $acquisitions;
        }
        return ErroMensage::errorMessage(ConstantMessage::ACQUISITION_NOT_FOUND);
    }

    public function destroyAcquisitionRelation($acquisition)
    {
        if(!is_null($acquisition)){
            $this->acquisitionsRespository->destroy($acquisition->id);
            return true;
        }
        return $acquisition;
    }
}