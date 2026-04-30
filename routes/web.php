<?php

use App\Controllers\AuthController;

return [
	['GET', '/', [AuthController::class, 'index']],
	['GET', '/login', [AuthController::class, 'showLogin']],
	['GET', '/register', [AuthController::class, 'showRegister']],
	['POST', '/login', [AuthController::class, 'login']],
	['POST', '/register', [AuthController::class, 'register']],
	['POST', '/logout', [AuthController::class, 'logout']],

	['GET', '/logout', [Dashboard::class, 'index']],

];
