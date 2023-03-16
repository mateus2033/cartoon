<?php
namespace App\Interfaces\Acquisitions;

interface AcquisitionsServiceInterface {
    
    public function listAcquisitions();
    public function destroyAcquisitionRelation($acquisition);

}