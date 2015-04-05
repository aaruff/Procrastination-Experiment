<?php
use Officium\Subject\Routers\LoginRouter;
use \Officium\Subject\Routers\SurveyRouter;
//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get(LoginRouter::uri(), LoginRouter::controllerRoute());
Route::post(LoginRouter::uri(), LoginRouter::controllerRoute('POST'));

// Incoming Survey
Route::get(SurveyRouter::uri(), SurveyRouter::controllerRoute());
Route::post(SurveyRouter::uri(), SurveyRouter::controllerRoute('POST'));


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
