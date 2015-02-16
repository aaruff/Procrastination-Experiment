<?php
$app->get('/researcher/login', function() {
    echo "Login";
});
$app->get('/experimenter/login', 'Officium\Controllers\Experimenter\Login:get');
$app->post('/experimenter/login', 'Officium\Controllers\Experimenter\Login:post');
