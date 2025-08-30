<?php
use App\Controllers\ClienteController;
use App\Controllers\NutricionistaController;
use App\Controllers\DietaController;
use App\Controllers\RefeicaoController;
use App\Controllers\PlanoAlimentarController;

// Rotas de clientes
$router->add('/clientes', ClienteController::class, 'index');
$router->add('/clientes/create', ClienteController::class, 'create');
$router->add('/clientes/edit/{id}', ClienteController::class, 'edit');
$router->add('/clientes/view/{id}', ClienteController::class, 'view');
$router->add('/clientes/delete/{id}', ClienteController::class, 'delete');
$router->add('/clientes/search', ClienteController::class, 'search');

// Rotas de nutricionistas
$router->add('/nutricionistas', NutricionistaController::class, 'index');
$router->add('/nutricionistas/create', NutricionistaController::class, 'create');
$router->add('/nutricionistas/edit/{id}', NutricionistaController::class, 'edit');
$router->add('/nutricionistas/delete/{id}', NutricionistaController::class, 'delete');

// Rotas de dietas
$router->add('/dietas', DietaController::class, 'index');
$router->add('/dietas/create', DietaController::class, 'create');
$router->add('/dietas/edit/{id}', DietaController::class, 'edit');
$router->add('/dietas/delete/{id}', DietaController::class, 'delete');

// Rotas de refeições
$router->add('/refeicoes', RefeicaoController::class, 'index');
$router->add('/refeicoes/create', RefeicaoController::class, 'create');

// Rotas de planos alimentares
$router->add('/planos', PlanoAlimentarController::class, 'index');
$router->add('/planos/create', PlanoAlimentarController::class, 'create');