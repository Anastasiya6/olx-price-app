<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'price',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
