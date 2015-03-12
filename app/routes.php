<?php
//---------------------------------------------------
// Subject Routes
//---------------------------------------------------
Route::get('/subject/login', '\Officium\Controllers\Subject\Login:get');
Route::post('/subject/login', '\Officium\Controllers\Subject\Login:post');

// Incoming Questionnaire
Route::get('/subject/questionnaire/incoming/a', '\Officium\Controllers\Subject\Questionnaire\Academic:get');
Route::post('/subject/questionnaire/incoming/a', '\Officium\Controllers\Subject\Questionnaire:Academic:post');
Route::get('/subject/questionnaire/incoming/ao', '\Officium\Controllers\Subject\Questionnaire\AcademicObligation:get');
Route::post('/subject/questionnaire/incoming/ao', '\Officium\Controllers\Subject\Questionnaire:AcademicObligation:post');


//---------------------------------------------------
// Experimenter Routes
//---------------------------------------------------
Route::get('/experimenter/login', '\Officium\Controllers\Experimenter\Login:get');
Route::post('/experimenter/login', 'Officium\Controllers\Experimenter\Login:post');
Route::get('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\Dashboard:get');
Route::post('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\Dashboard:post');
Route::get('/experiment/session/:id', 'Officium\Controllers\Experimenter\Experiment\Session:show');
Route::get('/experiment/session/', 'Officium\Controllers\Experimenter\Experiment\Session:get');
Route::post('/experiment/session/create', 'Officium\Controllers\Experimenter\Experiment\Session:create');
