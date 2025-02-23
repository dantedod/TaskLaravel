<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
  public static function decryptId($value)
  {
    try {
      //check if $value is encrypted
      //code...
      $value = Crypt::decrypt($value);
    } catch (DecryptException $e) {

      return redirect()->route('home');
    }

    return $value;
  }
}
