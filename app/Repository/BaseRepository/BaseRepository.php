<?php 

namespace App\Repository\BaseRepository;

abstract class BaseRepository 
{
    protected $modelClass;
    
    protected function setModel(string $modelClass) 
    { 
        $this->modelClass = $modelClass;
        return app($this->modelClass);
    }

    protected function getModel()
    {
        return app($this->modelClass);
    }

    public function findById(int $id)
    {   
        return $this->newQuery()->find($id);
    }

    public function create(array $data)
    {
        return $this->newQuery()->create($data);
    }

    public function update($product, array $productValid)
    {
        return $product->update($productValid);
    }

    public function destroy(int $id)
    {   
        return $this->getModel()->destroy($id);
    }

    protected function newQuery()
    {
        return $this->getModel()->newQuery();
    }

    protected function mountQuery($query = null, $limit = null, $columns = ['*'], $pageName = null, $page = null, $paginate)
    {   
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate) {
            return $query->paginate($limit, $columns, $pageName, $page);
        }

        if ($limit > 0 || $limit) {
            $query->take($limit);
        }
        
        return $query->get();
    }
}
