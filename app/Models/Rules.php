<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    use HasFactory;
    
    protected $table = 'rules';
    
    protected $fillable = [
        'permission',
    ];

    private string $permission;


    /**
     * Get the value of permission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of permission
     *
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }
}
