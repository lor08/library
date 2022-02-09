<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disk extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'year', 'price'];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
