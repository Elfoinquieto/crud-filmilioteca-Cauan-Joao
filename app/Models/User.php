<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    // --- RELACIONAMENTOS DE LIVROS ---

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // --- RELACIONAMENTOS DE FILMES ---

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function directors()
    {
        return $this->hasMany(Director::class);
    }

    public function actors()
    {
        return $this->hasMany(Actor::class);
    }
}