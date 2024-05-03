<?php

namespace App\Repository\Bank;

use App\Models\Bank;
use App\Interfaces\Bank\BankRepositoryInterface;
use App\Repository\BaseRepository\BaseRepository;

class BankRepository extends BaseRepository implements BankRepositoryInterface {

    protected $modelClass = Bank::class;
 
    public function getAll(int $page, int $perpage, bool $paginate)
    {   
       $query = $this->getModel()->newQuery();
       $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
       return $query;
    }

    public function getBankByCodeAndName(array $bank)
    {     
        $query = $this->getModel()
        ->where('code', '=', $bank['code'])
        ->where('name', '=', $bank['name']);
        return $query->first();
    }
}