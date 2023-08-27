<?php
namespace App\Enums;

enum Period : string
{
    case MONTHLY = 'MONTHLY';
    case YEARLY = 'YEARLY';
    case WEEKLY = 'WEEKLY';

    public function toSrLatinString() : string
    {
       return match($this) {
           self::MONTHLY => 'Mesečni',
           self::YEARLY => 'Godišnji',
           self::WEEKLY => 'Nedeljni',
       };
    }
}
