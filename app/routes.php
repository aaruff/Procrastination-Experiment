<?php
$app->get('/experimenter/login', 'Officium\Controllers\Experimenter\Login:get');
$app->post('/experimenter/login', 'Officium\Controllers\Experimenter\Login:post');
$app->get('/experiment/dashboard', 'Officium\Controllers\Experimenter\Experiment\Dashboard:get');
$app->get('/experiment/session', 'Officium\Controllers\Experimenter\Experiment\Session:get');
$app->post('/experiment/session', 'Officium\Controllers\Experimenter\Experiment\Session:post');
