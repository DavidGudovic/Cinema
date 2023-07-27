<?php
namespace App\Enums;


enum Durations : string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case LIFETIME = 'lifetime';
    case YEAR_TO_DATE = 'year to date';
}
