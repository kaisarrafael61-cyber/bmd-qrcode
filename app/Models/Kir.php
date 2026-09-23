<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kir extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi secara massal
    protected $guarded = [];
}