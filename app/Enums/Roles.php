<?php
namespace App\Enums;


enum Roles:string
{
    case ADMIN = 'ADMIN';
    case CLIENT = 'CLIENT';
    case BUSINESS_CLIENT = 'BUSINESS_CLIENT';
    case MANAGER = "MANAGER";
}
