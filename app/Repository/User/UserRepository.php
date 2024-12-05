<?php

namespace App\Repository\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Repository\BaseRepository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    protected $modelClass = User::class;

    public function getAll(int $page, int $perpage, bool $paginate)
    {   
        $query = $this->getModel()->newQuery();
        return $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
    }
}