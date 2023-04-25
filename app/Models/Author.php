<?php

namespace App\Models;

use App\ValueObjects\Name;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['email'];

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

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes): Name => new Name(
                first_name: $attributes['first_name'],
                last_name: $attributes['last_name'],
                patronymic: $attributes['patronymic'],
            ),
            set: fn (Name $value): array => [
                'first_name' => $value->first_name,
                'last_name' => $value->last_name,
                'patronymic' => $value->patronymic,
            ],
        );
    }

}
