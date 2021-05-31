<?php

use Liyuu\DcatCK\Http\Controllers;

//Route::get('dcat-ck', Controllers\DcatCkController::class.'@index');

Route::any('/ckfinder/connector', 'Liyuu\DcatCK\Http\Controllers\DcatCkController@requestAction')
    ->name('ckfinder-connector');

Route::any('/ckfinder/browser', 'Liyuu\DcatCK\Http\Controllers\\DcatCkController@browserAction')
    ->name('ckfinder-browser');
