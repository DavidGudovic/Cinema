<?php

namespace App\Enums;

enum Status : string
{
  case PENDING = "PENDING";
  case ACCEPTED = "ACCEPTED";
  case REJECTED = "REJECTED";
  case CANCELLED = "CANCELLED";

  public function toSrLatinString(): string
  {
    return match ($this) {
      self::PENDING =>   "Na čekanju",
      self::ACCEPTED =>  "Prihvaćen",
      self::REJECTED =>  "Odbijen",
      self::CANCELLED => "Otkazan",
    };
  }
}
