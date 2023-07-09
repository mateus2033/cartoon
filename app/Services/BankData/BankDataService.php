<?php

namespace App\Services\BankData;

use App\Interfaces\Bank\BankRepositoryInterface;
use App\Interfaces\BankData\BankDataRepositoryInterface;
use App\Interfaces\BankData\BankDataServiceInterface;
use App\Services\Bank\BankValidationForSaveService;
use App\Utils\ConstantMessage\bank\BankMessage;
use App\Utils\ConstantMessage\bankData\BankDataMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;

class BankDataService implements BankDataServiceInterface
{

    private BankDataRepositoryInterface $bankDataRepository;
    private BankRepositoryInterface $bankRepository;
    private BankValidationForSaveService $bankSaveService;
    private BankDataValidationForSaveService $bankDataSaveService;

    public function __construct(
        BankRepositoryInterface $bankRepository,
        BankDataRepositoryInterface $bankDataRepository,
        BankValidationForSaveService $bankSaveService,
        BankDataValidationForSaveService $bankDataSaveService
    ) {
        $this->bankRepository = $bankRepository;
        $this->bankDataRepository = $bankDataRepository;
        $this->bankDataSaveService = $bankDataSaveService;
        $this->bankSaveService = $bankSaveService;
    }

    public function index($paginate)
    {
        $response = $this->bankDataRepository->getAll();
        if (!$response->isEmpty())
            return $response;
        else
            return SuccessMessage::sucessMessage(BankDataMessage::LIST_BANK_DATA_EMPTY);
    }

    public function showBankDataById(int $bankDataId)
    {
        $bankData = $this->bankDataRepository->findById($bankDataId);
        if (!is_null($bankData))
            return $bankData;
        else
            return ErroMensage::errorMessage(BankDataMessage::BANK_DATA_NOT_FOUND);
    }

    public function manageStorageBankData(array $data, array $bank)
    {
        $bankData = $this->bankDataSaveService->validFormBankData($data);
        if (!is_array($bankData)) {
            return ErroMensage::errorMultipleMessage($bankData->message);
        }
        
        $bank = $this->getBank($bank);
        if (is_null($bank)) {
            $bankData = $this->bankDataRepository->create($bankData);
        }
        
        $bankData['bank_id'] = $bank->id;
        $response = $this->bankDataRepository->create($bankData);
        return $response;
    }

    private function getBank(array $bank)
    {
        $bank = $this->bankSaveService->validFormBank($bank);
        if (!is_array($bank)) {
            return ErroMensage::errorMultipleMessage($bank->message);
        }

        $bank = $this->bankRepository->getBankByCodeAndName($bank);
        if (is_null($bank)) {
            return ErroMensage::errorMessage(BankMessage::BANK_NOT_FOUND);
        }

        return $bank;
    }

    public function destroy(int $bankdata_id, int $user_id)
    {
        $bankData = $this->showBankDataById($bankdata_id);
        if (is_string($bankData)) {
            return ErroMensage::errorMessage($bankData);
        }

        if ($bankData['user_id'] == $user_id) {
            $this->bankDataRepository->destroy($bankData->id);
            return true;
        }

        return ErroMensage::errorMessage(BankDataMessage::ERRO_TO_DELETE_BANK_DATA);
    }
}
