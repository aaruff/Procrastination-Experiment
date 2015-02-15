<?php
$app->get('/researcher/login', function() {
    echo "Login";
});
$app->get('/experimenter/login', 'Officium\Controllers\Experimenter\Login:get');
