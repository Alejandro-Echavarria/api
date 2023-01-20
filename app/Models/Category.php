<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];
    protected $allowIncuded = ['posts', 'posts.user'];

    // Relación de uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeIncluded(Builder $query)
    {
        if (!empty([$this->allowIncuded, request('included')])) {

            $relations = explode(',', request('included')); // [posts, relation2]
            $allowIncuded = collect($this->allowIncuded);

            foreach ($relations as $key => $relationship) {
                if (!$allowIncuded->contains($relationship)) {

                    unset($relations[$key]);
                }
            }

            $query->with($relations);
        }
    }
}
