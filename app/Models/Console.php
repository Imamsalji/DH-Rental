<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Console extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'desc'];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
