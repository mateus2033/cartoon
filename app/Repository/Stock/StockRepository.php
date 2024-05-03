<?php

namespace App\Repository\Stock;

use App\Interfaces\Stock\StockRepositoryInterface;
use App\Models\Stock;
use App\Repository\BaseRepository\BaseRepository;

class StockRepository extends BaseRepository implements StockRepositoryInterface {

    protected $modelClass = Stock::class;

}