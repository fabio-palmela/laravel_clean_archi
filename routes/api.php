<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Api\LimiteGlobalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/atribuir-limite', [LimiteGlobalController::class, 'atribuirLimite'])->name('atribuirLimite');
Route::post('/atribuir-limite-xml', [LimiteGlobalController::class, 'atribuirLimiteXml'])->name('atribuirLimiteXml');