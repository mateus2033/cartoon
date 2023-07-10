<?php 

namespace App\Interfaces\BankData;

interface BankDataServiceInterface {
    public function index($page);
    public function showBankDataById(int $bankDataId);
    public function getBankDataOfUserSession(int $bankDataId);
    public function manageStorageBankData(array $data, array $bank);
    public function manageUpdateBankData(array $data, array $bank);
    public function destroy(int $bankdata_id, int $user_id);
}