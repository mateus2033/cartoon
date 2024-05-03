<?php

namespace App\Repository\Address;

use App\Interfaces\Address\AddressRepositoryInterface;
use App\Models\Address;
use App\Repository\BaseRepository\BaseRepository;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface {

    protected $modelClass = Address::class;

    public function findByRelations(int $data) 
    {
        return $this->getModel()->all()->where('user_id' ,'=', $data);
    }

    public function getAll(int $page, int $perpage, bool $paginate)
    {   
       $query = $this->getModel()->newQuery();
       $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
       return $query;
    }
}