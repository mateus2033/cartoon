<?php
namespace App\Interfaces\Acquisitions;

interface AcquisitionsServiceInterface {
    
    public function listAcquisitions($data);
    public function destroyAcquisitionRelation($acquisition);

}