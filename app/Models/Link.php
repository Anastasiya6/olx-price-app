<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['link'];

    public function subscriptions()
    {
        return $this->hasMany(User::class);
    }

    public function prices()
    {
        return $this->hasMany(User::class);
    }
}
