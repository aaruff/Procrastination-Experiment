<?php
use \Officium\User\Maps\LoginMap;
use \Officium\Subject\Maps\SurveyMap;
//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get(LoginMap::toUri(), LoginMap::toController());
Route::post(LoginMap::toUri(), LoginMap::toController('POST'));

// Incoming Survey
Route::get(SurveyMap::toUri(), SurveyMap::toController());
Route::post(SurveyMap::toUri(), SurveyMap::toController('POST'));


//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
Route::get('/experimenter/login', '\Officium\Controllers\Experimenter\ExperimenterLoginController:get');
Route::post('/experimenter/login', 'Officium\Controllers\Experimenter\ExperimenterLoginController:post');
Route::get('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\DashboardController:get');
Route::post('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\DashboardController:post');
Route::get('/experiment/session/:id', 'Officium\Controllers\Experimenter\Experiment\SessionController:show');
Route::get('/experiment/session/', 'Officium\Controllers\Experimenter\Experiment\SessionController:get');
Route::post('/experiment/session/create', 'Officium\Controllers\Experimenter\Experiment\SessionController:create');
