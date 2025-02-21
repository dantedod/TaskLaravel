<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use Illuminate\Support\Facades\Route;

//auth routers
Route::get("/login", [AuthController::class, "login"]);
Route::post("loginSubmit", [AuthController::class, "loginSubmit"]);



Route::get("/", [MainController::class, "index"]);
Route::get("/newNote", [MainController::class, "newNote"]);
Route::get("/logout", [AuthController::class, "logout"]);
