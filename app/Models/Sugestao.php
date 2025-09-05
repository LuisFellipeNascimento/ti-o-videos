<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sugestao extends Model
{
    use HasFactory;

    protected $fillable = ['youtube_link'];
    protected $table = 'sugestoes';
}
