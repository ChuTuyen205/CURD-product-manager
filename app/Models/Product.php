<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand_id', 'image', 'code', 'sensor_type', 'sensor_size', 'resolution', 'weight', 'battery', 'description'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
