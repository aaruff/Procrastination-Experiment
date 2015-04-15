<?php

use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;

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
Route::get(SessionMap::toUri(), SessionMap::toController());
Route::post(SessionMap::toUri(), SessionMap::toController('POST'));
//Route::get('/experiment/session/:id', 'Officium\Controllers\Experimenter\Experiment\SessionController:show');
