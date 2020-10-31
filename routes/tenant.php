<?php

    Route::get('/usuario/create', 'Tenant\CompanyController@create');

    Route::post('/usuario', 'Tenant\CompanyController@store');

    Route::get('/', 'Tenant\CompanyController@index');

?>