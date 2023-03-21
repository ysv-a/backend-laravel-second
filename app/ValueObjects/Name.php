<?php

namespace App\ValueObjects;

class Name
{
    public readonly string $full_name;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string|null $patronymic,
    ) {
        if($this->patronymic){
            $this->full_name = $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic;
        }else{
            $this->full_name = $this->first_name . ' ' . $this->last_name;
        }
    }

}
