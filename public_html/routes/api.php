<?php

use App\Http\Controllers\AIChatController;
use Illuminate\Support\Facades\Route;

Route::post('/ai-chat', [AIChatController::class, 'chat'])->name('ai.chat');