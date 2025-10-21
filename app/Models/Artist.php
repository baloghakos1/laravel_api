<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    public $timestamps = false;

    function member()
    {
        return $this->hasMany(Member::class);
    }


    function album()
    {
        return $this->hasMany(Album::class);
    }

    protected $fillable = [
        'name',
        'nationality',
        'image',
        'description',
        'is_band'
    ];
}
