<?php
namespace App\Enums;


enum Roles:string
{
    case ADMIN = 'ADMIN';
    case CLIENT = 'CLIENT';
    case BUSINESS_CLIENT = 'BUSINESS_CLIENT';
    case MANAGER = "MANAGER";

    public function toSrLatinString(): string
    {
        return match ($this->value) {
            'ADMIN' => 'Admin',
            'CLIENT' => 'Klijent',
            'BUSINESS_CLIENT' => 'Biznis',
            'MANAGER' => 'Menadžer',
        };
    }
}
