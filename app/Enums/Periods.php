<?php
namespace App\Enums;

enum Periods : string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case WEEKLY = 'lifetime';

    public function toSrLatinString() : string
    {
       return match($this) {
           self::MONTHLY => 'Mesečni',
           self::YEARLY => 'Godišnji',
           self::WEEKLY => 'Nedeljni',
       };
    }
}
