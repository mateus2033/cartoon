<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'product_id'
    ];

   private int $user_id;
   private int $product_id;

   /**
    * Get the value of user_id
    */ 
   public function getUser_id(): int
   {
      return $this->user_id;
   }

   /**
    * Set the value of user_id
    *
    * @return  self
    */ 
   public function setUser_id($user_id): void
   {
      $this->user_id = $user_id;
   }

   /**
    * Get the value of product_id
    */ 
   public function getProduct_id(): int
   {
      return $this->product_id;
   }

   /**
    * Set the value of product_id
    *
    */ 
   public function setProduct_id($product_id): void
   {
      $this->product_id = $product_id;
   }
}
