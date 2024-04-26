<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;
    public function musics()
    {
        return $this->belongsToMany(Music::class, 'music_instrument');
    }
}
