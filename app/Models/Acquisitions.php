<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acquisitions extends Model
{
    use HasFactory;
    protected $table = 'acquisitions';
    protected $fillable = [
        'id',
        'period',
        'amount',
        'product_id'
    ];

    private int $id;
    private string $period;
    private int $amount;
    private int $product_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
