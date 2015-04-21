<?php

use Officium\Framework\Maps\TreatmentMap;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use Statical\SlimStatic\Route;

//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get(LoginMap::toUri(), LoginMap::toController());
Route::post(LoginMap::toUri(), LoginMap::toController(LoginMap::$POST));

// Incoming Survey
Route::get(SurveyMap::toUri(), SurveyMap::toController());
Route::post(SurveyMap::toUri(), SurveyMap::toController(SurveyMap::$POST));


//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
Route::get(DashboardMap::toUri(), DashboardMap::toController());
Route::post(DashboardMap::toUri(), DashboardMap::toController(DashboardMap::$POST));
Route::get(SessionMap::toUri(), SessionMap::toController());
Route::post(SessionMap::toUri(), SessionMap::toController(SessionMap::$POST));
Route::get(TreatmentMap::toUri(TreatmentMap::$ID), TreatmentMap::toController());
