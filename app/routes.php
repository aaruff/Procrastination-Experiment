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
use Officium\Framework\Maps\CertificateMap;
use Officium\Framework\Maps\DeadlineMap;
use Officium\Framework\Maps\RankTaskCompletionMap;
use Officium\Framework\Maps\TaskMap;
use Officium\Framework\Maps\LandingPageMap;
use Officium\Framework\Maps\OutgoingQuestionnaireMap;
use Officium\Framework\Maps\GameOverMap;
use Officium\Framework\Maps\FileNotFoundMap;

//---------------------------------------------------
// Error Routes
//---------------------------------------------------
Route::get(FileNotFoundMap::toUri(), FileNotFoundMap::toController());

//---------------------------------------------------
// User Routes
//---------------------------------------------------
Route::get(LoginMap::toUri(), LoginMap::toController());
Route::post(LoginMap::toUri(), LoginMap::toController(LoginMap::$POST));


//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
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

// - Certificate
Route::get(CertificateMap::toUri(), CertificateMap::toController());
Route::post(CertificateMap::toUri(), CertificateMap::toController(Map::$POST));

// - Attentive Rankings
Route::get(AttentiveRankMap::toUri(), AttentiveRankMap::toController());
Route::post(AttentiveRankMap::toUri(), AttentiveRankMap::toController(Map::$POST));

// - Subject Task Deadlines
Route::get(DeadlineMap::toUri(), DeadlineMap::toController());
Route::post(DeadlineMap::toUri(), DeadlineMap::toController(Map::$POST));

// - Rank Task Completion
Route::get(RankTaskCompletionMap::toUri(), RankTaskCompletionMap::toController());
Route::post(RankTaskCompletionMap::toUri(), RankTaskCompletionMap::toController(Map::$POST));

//---------------------
// Experiment
//---------------------
// - Landing Page
Route::get(LandingPageMap::toUri(), LandingPageMap::toController());

// - Task
Route::get(TaskMap::toUri(), TaskMap::toController())->conditions(TaskMap::$CONDITIONS);
Route::post(TaskMap::toUri(), TaskMap::toController(Map::$POST))->conditions(TaskMap::$CONDITIONS);

// - Outgoing Questionnaire
Route::get(OutgoingQuestionnaireMap::toUri(), OutgoingQuestionnaireMap::toController());
Route::post(OutgoingQuestionnaireMap::toUri(), OutgoingQuestionnaireMap::toController(Map::$POST));

// - Outgoing Questionnaire
Route::get(GameOverMap::toUri(), GameOverMap::toController());


//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
// - Experimenter Dashboard
Route::get(DashboardMap::toUri(), DashboardMap::toController());
Route::post(DashboardMap::toUri(), DashboardMap::toController(Map::$POST));

Route::get(SessionMap::toUri(), SessionMap::toController());
Route::post(SessionMap::toUri(), SessionMap::toController(Map::$POST));

Route::get(TreatmentMap::toUri(TreatmentMap::$ID), TreatmentMap::toController());

