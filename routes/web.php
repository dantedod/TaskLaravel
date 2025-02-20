<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  echo "hello";
});

Route::get('/about', function () {
  echo "About us";
});
