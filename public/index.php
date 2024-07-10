<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\InitController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router();


// ? Inicio ------------------------------------------------------------------------------
$router->get('/', [InitController::class, 'index']);


// Paginas secundarias
$router->get('/not-found', [InitController::class, 'notFound']);
$router->get('/confirmaciones', [InitController::class, 'confirmaciones']);


// ? Auth ------------------------------------------------------------------------------
$router->get('/login', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'index']);

// Logout
$router->post('/logout', [LoginController::class, 'logout']);

// Crear Cuenta
$router->get('/create-account', [LoginController::class, 'createAccount']);
$router->post('/create-account', [LoginController::class, 'createAccount']);

// Olvide Contraseña
$router->get('/forgot-password', [LoginController::class, 'forgotPassword']);
$router->post('/forgot-password', [LoginController::class, 'forgotPassword']);

// Recuperar Cuenta
$router->get('/recovery-password', [LoginController::class, 'recoveryPassword']);
$router->post('/recovery-password', [LoginController::class, 'recoveryPassword']);

// Confirmacion de cuenta
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);


// ? Dashboard ------------------------------------------------------------------------------

$router->get('/dashboard', [DashboardController::class, 'index']);

$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);

$router->get('/create-project', [DashboardController::class, 'createProject']);
$router->post('/create-project', [DashboardController::class, 'createProject']);

$router->get('/project', [DashboardController::class, 'project']);



// ? ----------------------------------------------------------------------------------------



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
