<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Baris ini wajib ada agar nama dan harga baju tidak diblokir saat disimpan
    protected $fillable = ['name', 'description', 'price', 'image'];
}
