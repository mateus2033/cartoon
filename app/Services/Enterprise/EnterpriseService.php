<?php 

namespace App\Services\Enterprise;

use App\Interfaces\Enterprise\EnterpriseRepositoryInterface;
use App\Interfaces\Enterprise\EnterpriseServiceInterface;
use App\Utils\ConstantMessage\enterprise\EnterpriseMessage;
use App\Utils\SuccessMessage\SuccessMessage;

class EnterpriseService implements EnterpriseServiceInterface 
{
    private $enterpriseRepository;
    private $enterpriseValidationForSaveService;
    private $enterpriseValidationForUpdateService;

    public function __construct(
        EnterpriseRepositoryInterface $enterpriseRepository,
        EnterpriseValidationForSaveService $enterpriseValidationForSaveService,
        EnterpriseValidationForUpdateService $enterpriseValidationForUpdateService
    ){
        $this->enterpriseRepository = $enterpriseRepository;
        $this->enterpriseValidationForSaveService = $enterpriseValidationForSaveService;
        $this->enterpriseValidationForUpdateService = $enterpriseValidationForUpdateService;
    }
    
    public function show(int $enterprise_id)
    {
        $response = $this->enterpriseRepository->findById($enterprise_id);
        dd($response);
        if (!$response->isEmpty())
            return $response;
        else
            return SuccessMessage::sucessMessage(EnterpriseMessage::ENTERPRISE_NOT_FOUND);
    }

    public function manageStorageEnterprise(array $enterprise, array $address)
    {
        //
    }

    public function manageUpdateEnterprise(array $enterprise)
    {
        //
    }

    public function manageDestroyEnterprise(int $enterprise_id)
    {
        //
    }
}
