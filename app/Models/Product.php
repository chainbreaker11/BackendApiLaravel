<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // esto es para que se pueda usar el metodo factory que se usa para crear datos de prueba

class Product extends Model
{
    use HasFactory;
    protected $fillable =[ // esto es para que se pueda usar el metodo create en el controlador
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image'
    ];
     // Definir el accesor para la imagen
     public function getImageAttribute($value)
     {
         // Si hay una imagen, devolver la URL completa con 'asset'
         return $value ? asset('storage/' . $value) : null;
     }
}
