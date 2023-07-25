<?php

namespace App\Enums;

enum Status : string
{
  case ON_HOLD = "on hold";
  case SUCCESSFUL = "successful";
  case CANCELED = "canceled";
}
