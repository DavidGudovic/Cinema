<?php

namespace App\Enums;

enum Status : string
{
  case PENDING = "PENDING";
  case ACCEPTED = "ACCEPTED";
  case REJECTED = "REJECTED";
  case CANCELLED = "CANCELLED";
}
