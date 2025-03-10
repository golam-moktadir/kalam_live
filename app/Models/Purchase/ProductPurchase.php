<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\Supplier;

class ProductPurchase extends Model
{
    use HasFactory;
    protected $primaryKey = 'purchase_id';
    public function details(){
        return $this->hasMany(ProductPurchaseDetail::class, 'purchase_id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
