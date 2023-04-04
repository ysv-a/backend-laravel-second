<?php

namespace App\Cast;

use Attribute;
use App\ValueObjects\PriceReverse;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToMoney implements PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper) : mixed
    {
        return new PriceReverse($value);
    }
}
