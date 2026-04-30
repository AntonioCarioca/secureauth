<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;

return [
	['GET', '/', [AuthController::class, 'index']],
	['GET', '/login', [AuthController::class, 'showLogin']],
	['GET', '/register', [AuthController::class, 'showRegister']],
	['POST', '/login', [AuthController::class, 'login']],
	['POST', '/register', [AuthController::class, 'register']],
	['GET', '/logout', [AuthController::class, 'logout']],

	['GET', '/dashboard', [DashboardController::class, 'index']],

];
