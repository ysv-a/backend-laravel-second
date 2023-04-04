<?php

namespace App\Cast;

use App\ValueObjects\Name;
use Attribute;

use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToName implements PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper) : mixed
    {
        return new Name($value['first_name'], $value['last_name'], $value['patronymic']);
    }
}
