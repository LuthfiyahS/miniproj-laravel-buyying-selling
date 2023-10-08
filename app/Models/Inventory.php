<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'name', 'price', 'stock'];

    public function sales_detail()
    {
        return $this->hashMany(SalesDetail::class);
    }

    public function purchase_detail()
    {
        return $this->hashMany(PurchaseDetail::class);
    }
}
