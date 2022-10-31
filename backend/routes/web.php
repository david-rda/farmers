<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;

Route::post("/get_farmer", [FarmerController::class, "getFarmerData"])->middleware("auth:api");

Route::post("/farmer_check", [FarmerController::class, "checkFarmer"])->middleware("auth:api");

Route::post("/login", [AuthController::class, "Login"]);

Route::post("/logout", [LogoutController::class, "Logout"]);

Route::post("/change_password", [PasswordController::class, "ChangePassword"])->middleware("auth:api");

Route::group(["prefix" => "user", "middleware" => "auth:api"], function() {
    Route::post("/add", [UserController::class, "Add_User"]);
    
    Route::post("/edit/{id}", [UserController::class, "Edit_User"])->where(["id" => "[0-9]+"]);

    Route::get("/list", [UserController::class, "User_List"]);

    Route::post("/delete/{id}", [UserController::class, "Delete_User"])->where(["id" => "[0-9]+"]);

    Route::get("/get/{id}", [UserController::class, "Get_User"])->where(["id" => "[0-9]+"]);
});

?>