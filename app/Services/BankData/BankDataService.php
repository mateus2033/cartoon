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
use App\Services\BankData\BankDataValidationForUpdateService;

class BankDataService implements BankDataServiceInterface
{

    private BankDataRepositoryInterface $bankDataRepository;
    private BankRepositoryInterface $bankRepository;
    private BankValidationForSaveService $bankSaveService;
    private BankDataValidationForSaveService $bankDataSaveService;
    private BankDataValidationForUpdateService $bankDataUpdateService;

    public function __construct(
        BankRepositoryInterface $bankRepository,
        BankDataRepositoryInterface $bankDataRepository,
        BankValidationForSaveService $bankSaveService,
        BankDataValidationForSaveService $bankDataSaveService,
        BankDataValidationForUpdateService $bankDataUpdateService
    ) {
        $this->bankRepository = $bankRepository;
        $this->bankDataRepository = $bankDataRepository;
        $this->bankDataSaveService = $bankDataSaveService;
        $this->bankSaveService = $bankSaveService;
        $this->bankDataUpdateService = $bankDataUpdateService;
    }

    public function index($page)
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

    public function getBankDataOfUserSession(int $bankDataId)
    {
        $bankData = $this->bankDataRepository->findById($bankDataId);
        if (is_null($bankData)) {
            return ErroMensage::errorMessage(BankDataMessage::BANK_DATA_NOT_FOUND);
        }
       
        if (auth('api')->user()->id != $bankData->user->id) {
            return ErroMensage::errorMessage(BankDataMessage::USER_WITHOUT_PERMISSION);
        }
        return $bankData;
    }

    public function manageStorageBankData(array $data, array $bank)
    {
        $bankData = $this->bankDataSaveService->validFormBankData($data);
        if (!is_array($bankData)) {
            return ErroMensage::errorMultipleMessage($bankData->message);
        }

        $bank = $this->getBank($bank);
        if (is_array($bank)) {
            return $bank;
        }

        $bankData['bank_id'] = $bank->id;
        $bankData = $this->bankDataRepository->create($bankData);
        return $bankData;
    }

    public function manageUpdateBankData(array $data, array $bank)
    {
        $data = $this->bankDataUpdateService->validFormBankData($data);
        if (!is_array($data)) {
            return ErroMensage::errorMultipleMessage($data->message);
        }

        $bankData = $this->getBankDataOfUserSession($data['id']);
        if (is_array($bankData)) {
            return $bankData;
        }

        $bank = $this->getBank($bank);
        if (is_array($bank)) {
            return $bank;
        }

        $bankData['bank_id'] = $bank->id;
        $this->bankDataRepository->update($bankData, $data);
        return $bankData;
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
