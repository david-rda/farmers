<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PasswordController;

Route::post("/get_farmer", [FarmerController::class, "getFarmerData"]);

Route::post("/farmer_check", [FarmerController::class, "checkFarmer"]);

Route::post("/login", [AuthController::class, "Login"]);

Route::post("/logout", [LogoutController::class, "Logout"]);

Route::post("/change_password", [PasswordController::class, "ChangePassword"]);

?>