<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public static function nameIdPluck()
    {
        $authors = Author::select('id', 'first_name', 'last_name', 'patronymic')->get();
        $authors = $authors->mapWithKeys(fn ($author) => [$author->id => "{$author->first_name} {$author->last_name} {$author->patronymic}"]);

        return $authors->all();
    }
}
