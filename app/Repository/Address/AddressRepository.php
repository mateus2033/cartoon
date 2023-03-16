<?php

namespace App\Repository\Address;

use App\Interfaces\Address\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface {


    protected Address $model;
    
    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Address $address, array $addressValid)
    {
        return $address->update($addressValid);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }

    public function findByRelations(int $data) 
    {
        return $this->model->all()->where('user_id' ,'=', $data);
    }
}