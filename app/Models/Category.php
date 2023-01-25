<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Category extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable     = ['name', 'slug'];
    protected $allowSort    = ['id', 'name', 'slug'];
    protected $allowFilter  = ['id', 'name', 'slug'];
    protected $allowIncuded = ['posts', 'posts.user'];

    // Relación de uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
