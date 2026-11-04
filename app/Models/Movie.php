<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'director_id', 'title', 'genre', 'description'];

    public const GENRES = [
        'Ação',
        'Aventura',
        'Comédia',
        'Drama',
        'Ficção Científica',
        'Terror',
        'Suspense',
        'Romance',
        'Documentário',
        'Animação'
    ];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}