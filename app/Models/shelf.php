<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\items;

class shelf extends Model
{
    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(items::class, 'shelf_id');
    }

    use HasFactory;
}
