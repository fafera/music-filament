<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';
    use HasFactory;

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'music_genre');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'music_instrument');
    }
    public function keysList(){
        return [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
            'd' => 'D',
            'e' => 'E',
            'f' => 'F',
            'g' => 'G'
        ];
    }
}
