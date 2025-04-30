<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;

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

// Route pour vérifier les nouveaux messages
Route::middleware('auth:sanctum')->get('/check-messages', 'App\Http\Controllers\Api\MessageCheckController@checkNewMessages');

// Route pour récupérer les nouveaux messages d'une conversation
Route::middleware('auth:sanctum')->get('/conversations/{conversationId}/messages', 'App\Http\Controllers\Api\ConversationMessagesController@getNewMessages');
