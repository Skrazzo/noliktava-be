<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\shelf;

class items extends Model
{
    protected $fillable = [
        'shelf_id',
        'name',
        'price',
        'image_url',
    ];

    public function shelf()
    {
        return $this->belongsTo(shelf::class, 'shelf_id');
    }

    use HasFactory;
}
