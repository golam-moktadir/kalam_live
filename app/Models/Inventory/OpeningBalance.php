<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class OpeningBalance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'product_transactions';
    protected $primaryKey = 'trans_id';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
