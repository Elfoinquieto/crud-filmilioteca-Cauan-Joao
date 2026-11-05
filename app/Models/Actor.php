<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * O ator/atriz pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * O ator/atriz pode participar de vários filmes (Muitos para Muitos).
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'actor_movie');
    }
}