<?php
use \Officium\User\Maps\LoginMap;
use \Officium\Subject\Maps\SurveyMap;
use \Officium\Experimenter\Maps\DashboardMap;
use \Officium\Experimenter\Maps\SessionMap;
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
Route::get(DashboardMap::toUri(), DashboardMap::toController());
Route::post(DashboardMap::toUri(), DashboardMap::toController('POST'));
Route::get('/experiment/session/:id', 'Officium\Controllers\Experimenter\Experiment\SessionController:show');
Route::get(SessionMap::toUri(), SessionMap::toController());
Route::post('/experiment/session/create', 'Officium\Controllers\Experimenter\Experiment\SessionController:create');
