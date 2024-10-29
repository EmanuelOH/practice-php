<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model
{
    // Incluye el trait HasFactory, que permite crear instancias del modelo usando factories.
    use HasFactory;

    // Define los campos que pueden ser asignados de forma masiva para evitar la asignación de campos no autorizados.
    protected $fillable = ['user_id', 'google_id', 'avatar'];

    // Define una relación de pertenencia con el modelo `User`.
    public function user(){
        
        // Establece que cada instancia de `GoogleUser` pertenece a un usuario en la tabla `users`.
        // `belongsTo` indica que `GoogleUser` está vinculado a un solo `User` mediante `user_id`.
        return $this->belongsTo(User::class);
    }
}
