<?php

namespace App\Enums;

enum Status : string
{
  case PENDING = "pending";
  case ACCEPTED = "accepted";
  case REJECTED = "rejected";
  case CANCELLED = "cancelled";
}
