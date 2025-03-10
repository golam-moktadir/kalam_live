<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\Supplier;
use App\Models\Product\Product;

class ProductPurchaseDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['purchase_id', 'product_id', 'item_qty', 'item_price', 'total_price'];

    public function purchase(){
        return $this->belongsTo(ProductPurchase::class, 'purchase_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

}
