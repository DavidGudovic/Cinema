<?php

namespace App\Enums;

enum Status : string
{
  case ON_HOLD = "on hold";
  case ACCEPTED = "accepted";
  case REJECTED = "rejected";
}
