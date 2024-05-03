<?php

namespace App\Repository\Product;

use App\Interfaces\Product\ProductRepositoryInterface;
use App\Models\Product;
use App\Repository\BaseRepository\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface {

    protected $modelClass = Product::class;

    public function getAll(int $page, int $perpage, bool $paginate)
    {   
        $query = $this->getModel()->newQuery();
        $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
        return $query;
    }

    public function getAllWithRelations(int $page, int $perpage, bool $paginate, array $relations = [])
    {
        $query = $this->modelClass::with($relations);
        $query = $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
        return $query;
    }

    public function getProductMoreSold(int $page, int $perpage, bool $paginate, string  $dateInitial, string $dateNow)
    {
        $query = $this->modelClass::join('acquisitions', 'products.id', 'acquisitions.product_id')
        ->whereBetween('acquisitions.period',[$dateInitial, $dateNow])
        ->orderBy('acquisitions.amount');
        return $this->mountQuery($query, $perpage, $columns = ['*'], $pageName = null, $page, $paginate);
    }
}