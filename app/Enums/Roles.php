<?php
namespace App\Enums;


enum Roles:string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case BUSINESS_CLIENT = 'business client';
    case MANAGER = "manager";
}
