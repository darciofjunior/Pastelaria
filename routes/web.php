<?php

use Illuminate\Support\Facades\Route;

Route::get('/enviar_email_cliente', 'Api\ClienteController@enviar_email');
