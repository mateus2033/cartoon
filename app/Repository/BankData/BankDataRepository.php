<?php

namespace App\Repository\BankData;

use App\Interfaces\BankData\BankDataRepositoryInterface;
use App\Models\BankData;
use App\Repository\BaseRepository\BaseRepository;

class BankDataRepository extends BaseRepository implements BankDataRepositoryInterface
{
    protected $modelClass = BankData::class;

    public function getAll(int $page, int $perpage, bool $paginate)
    {   
       $query = $this->getModel()->newQuery();
       $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
       return $query;
    }
}
