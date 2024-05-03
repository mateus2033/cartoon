<?php

namespace App\Services\Bank;

use App\Interfaces\Bank\BankRepositoryInterface;
use App\Interfaces\Bank\BankServiceInterface;
use App\Services\Bank\BankValidationForSaveService;
use App\Services\Bank\BankValidationForUpdateService;
use App\Utils\ConstantMessage\bank\BankMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;

class BankService implements BankServiceInterface
{
    protected $bankRepository;
    protected $bankValidationForSaveService;
    protected $bankValidationForUpdateService;

    public function __construct(
        BankRepositoryInterface $bankRepository,
        BankValidationForSaveService $bankValidationForSaveService,
        BankValidationForUpdateService $bankValidationForUpdateService
    ) {
        $this->bankRepository = $bankRepository;
        $this->bankValidationForSaveService = $bankValidationForSaveService;
        $this->bankValidationForUpdateService = $bankValidationForUpdateService;
    }

    public function index($data)
    {
        $response = $this->bankRepository->getAll($data->page, $data->perpage, $data->paginate);
        if (!$response->isEmpty())
            return $response;
        else
            return SuccessMessage::sucessMessage(BankMessage::LIST_BANK_EMPTY);
    }

    public function getBankById(int $bank_id)
    {
        $bank = $this->bankRepository->findById($bank_id);
        if (is_null($bank)) {
            return ErroMensage::errorMessage(BankMessage::BANK_NOT_FOUND);
        }
        return $bank;
    }

    private function getBank(array $bank)
    {
        $bank = $this->bankRepository->getBankByCodeAndName($bank);
        if (!is_null($bank)) {
            return ErroMensage::errorMessage(BankMessage::BANK_ALREADY_REGISTERED);
        }
        return true;;
    }

    public function manageStorageBank(array $bank)
    {
        $bank = $this->bankValidationForSaveService->validFormBank($bank);
        if (!is_array($bank)) {
            return ErroMensage::errorMultipleMessage($bank->message);
        }
       
        $findbank = $this->getBank($bank);
        if (is_array($findbank)) {
            return $findbank;
        }

        $bank = $this->bankRepository->create($bank);
        return $bank;
    }

    public function manageUpdateBank(array $bank)
    {
        $bank = $this->bankValidationForUpdateService->validFormBank($bank);
        if (!is_array($bank)) {
            return ErroMensage::errorMultipleMessage($bank->message);
        }

        $findbank = $this->getBankById($bank['id']);
        if(is_array($findbank)) {
            return $findbank;
        }

        $this->bankRepository->update($findbank, $bank);
        return $findbank;
    }

    public function manageDeleteBank(int $bank_id)
    {
        $bank = $this->getBankById($bank_id);
        if(is_array($bank)) {
            return $bank;
        }
        
        if($bank->active == BankMessage::ACTIVE){ 
            return ErroMensage::errorMessage(BankMessage::ACTIVE_BANK_CANNOT_BE_DELETED);
        }
     
        if($bank->bankData->isNotEmpty()) {
            return ErroMensage::errorMessage(BankMessage::BANK_WITH_ACTIVE_RELASHIP);
        }
        
        $this->bankRepository->destroy($bank->id);
        return true;
    }
}
