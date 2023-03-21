<?php

namespace App\Models;

use App\ValueObjects\Price;
use App\ValueObjects\PriceReverse;
use App\Exceptions\BusinessException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;


    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes): Price => new Price(
                cent: $value,
            ),

        );
    }

    public function allowedPublish()
    {
        if($this->price->cent <= 100){
            throw new BusinessException("The book cannot be published");
        }
    }

}
