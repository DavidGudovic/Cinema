<?php
namespace App\Enums;

enum Periods : string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case WEEKLY = 'lifetime';

    public static function toSrLatinString(Periods $period) : string
    {
        return match($period) {
            Periods::MONTHLY => 'Mesečni',
            Periods::YEARLY => 'Godišnji',
            Periods::WEEKLY => 'Nedeljni',
        };
    }
}
