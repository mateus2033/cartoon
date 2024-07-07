<?php 

namespace App\Repository\Enterprise;

use App\Interfaces\Enterprise\EnterpriseRepositoryInterface;
use App\Models\Enterprise;
use App\Repository\BaseRepository\BaseRepository;

class EnterpriseRepository extends BaseRepository implements EnterpriseRepositoryInterface
{
    protected $modelClass = Enterprise::class;
}