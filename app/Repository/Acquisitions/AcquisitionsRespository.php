<?php

namespace App\Repository\Acquisitions;

use App\Interfaces\Acquisitions\AcquisitionsRepositoryInterface;
use App\Models\Acquisitions;
use App\Repository\BaseRepository\BaseRepository;

class AcquisitionsRespository extends BaseRepository implements AcquisitionsRepositoryInterface {

   protected $modelClass = Acquisitions::class;

   public function getAll(int $page, int $perpage, bool $paginate)
   {   
      $query = $this->getModel()->newQuery();
      $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
      return $query;
   }
}
