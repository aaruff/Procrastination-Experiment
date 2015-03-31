<?php
//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get('/subject/login', '\Officium\Controllers\Subject\SubjectLoginController:get');
Route::post('/subject/login', '\Officium\Controllers\Subject\SubjectLoginController:post');

// Incoming Survey
Route::get('/subject/survey/:id', '\Officium\Controllers\Subject\SurveyController:get');
Route::post('/subject/survey/:id', '\Officium\Controllers\Subject\SurveyController:post');


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
