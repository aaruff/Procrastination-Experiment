<?php

use Officium\Framework\Maps\TreatmentMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use Statical\SlimStatic\Route;
use Officium\Framework\Maps\GeneralAcademicMap;
use Officium\Framework\Maps\AcademicObligationMap;
use Officium\Framework\Maps\ResourceMap as Map;
use Officium\Framework\Maps\ExternalObligationMap;
use Officium\Framework\Maps\AttentiveRankMap;

//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get(LoginMap::toUri(), LoginMap::toController());
Route::post(LoginMap::toUri(), LoginMap::toController(LoginMap::$POST));

//---------------------
// Incoming Surveys
//---------------------

// - General Academic
Route::get(GeneralAcademicMap::toUri(), GeneralAcademicMap::toController());
Route::post(GeneralAcademicMap::toUri(), GeneralAcademicMap::toController(Map::$POST));

// - Academic Obligations
Route::get(AcademicObligationMap::toUri(), AcademicObligationMap::toController());
Route::post(AcademicObligationMap::toUri(), AcademicObligationMap::toController(Map::$POST));

// - External Obligations
Route::get(ExternalObligationMap::toUri(), ExternalObligationMap::toController());
Route::post(ExternalObligationMap::toUri(), ExternalObligationMap::toController(Map::$POST));

// - Attentive Rankings
Route::get(AttentiveRankMap::toUri(), AttentiveRankMap::toController());
Route::post(AttentiveRankMap::toUri(), AttentiveRankMap::toController(Map::$POST));

//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
Route::get(DashboardMap::toUri(), DashboardMap::toController());
Route::post(DashboardMap::toUri(), DashboardMap::toController(Map::$POST));
Route::get(SessionMap::toUri(), SessionMap::toController());
Route::post(SessionMap::toUri(), SessionMap::toController(Map::$POST));
Route::get(TreatmentMap::toUri(TreatmentMap::$ID), TreatmentMap::toController());
