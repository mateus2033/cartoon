<?php

namespace App\Services\Acquisitions;

use App\Interfaces\Acquisitions\AcquisitionsRepositoryInterface;
use App\Interfaces\Acquisitions\AcquisitionsServiceInterface;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class AcquisitionsService implements AcquisitionsServiceInterface {

    private AcquisitionsRepositoryInterface $acquisitionsRespository;  

    public function __construct(AcquisitionsRepositoryInterface $acquisitionsRespository)
    {
        $this->acquisitionsRespository = $acquisitionsRespository;
    }

    public function listAcquisitions($data)
    {
        $acquisitions = $this->acquisitionsRespository->getAll($data->page, $data->perpage, $data->paginate);
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