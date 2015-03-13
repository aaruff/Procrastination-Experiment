<?php
//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get('/subject/login', '\Officium\Controllers\Subject\SubjectLoginController:get');
Route::post('/subject/login', '\Officium\Controllers\Subject\SubjectLoginController:post');

// Incoming Questionnaire
Route::get('/subject/questionnaire/a', '\Officium\Controllers\Subject\Questionnaire\GeneralAcademicController:get');
Route::post('/subject/questionnaire/a', '\Officium\Controllers\Subject\Questionnaire\GeneralAcademicController:post');
Route::get('/subject/questionnaire/ao', '\Officium\Controllers\Subject\Questionnaire\AcademicObligationController:get');
Route::post('/subject/questionnaire/ao', '\Officium\Controllers\Subject\Questionnaire\AcademicObligationController:post');
Route::get('/subject/questionnaire/eo', '\Officium\Controllers\Subject\Questionnaire\ExternalObligationController:get');
Route::post('/subject/questionnaire/eo', '\Officium\Controllers\Subject\Questionnaire\ExternalObligationController:post');
Route::get('/subject/questionnaire/at', '\Officium\Controllers\Subject\Questionnaire\AttentiveOrganizedController:get');
Route::post('/subject/questionnaire/at', '\Officium\Controllers\Subject\Questionnaire\AttentiveOrganizedController:post');


//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
Route::get('/experimenter/login', '\Officium\Controllers\Experimenter\LoginController:get');
Route::post('/experimenter/login', 'Officium\Controllers\Experimenter\LoginController:post');
Route::get('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\DashboardController:get');
Route::post('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\DashboardController:post');
Route::get('/experiment/session/:id', 'Officium\Controllers\Experimenter\Experiment\SessionController:show');
Route::get('/experiment/session/', 'Officium\Controllers\Experimenter\Experiment\SessionController:get');
Route::post('/experiment/session/create', 'Officium\Controllers\Experimenter\Experiment\SessionController:create');
