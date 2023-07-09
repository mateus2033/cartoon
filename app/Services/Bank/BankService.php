<?php

namespace App\Services\Bank;

use App\Interfaces\Bank\BankServiceInterface;
use App\Interfaces\Bank\BankRepositoryInterface;
use App\Services\Bank\BankValidationForSaveService;
use App\Services\Bank\BankValidationForUpdateService;

class BankService implements BankServiceInterface {

    protected $bankRepository;
    protected $bankValidationForSaveService;
    protected $bankValidationForUpdateService;

    public function __construct(
        BankRepositoryInterface $bankRepository,
        BankValidationForSaveService $bankValidationForSaveService,
        BankValidationForUpdateService $bankValidationForUpdateService
    ){
        $this->bankRepository = $bankRepository;
        $this->bankValidationForSaveService = $bankValidationForSaveService;
        $this->bankValidationForUpdateService = $bankValidationForUpdateService;
    }

    public function index($paginate)
    {
        //
    }

    public function manageStorageBank(array $bank, int $user_id)
    {
        //
    }

    public function manageUpdateBank()
    {
        //
    }

    public function manageDeleteBank()
    {
        //
    }
}