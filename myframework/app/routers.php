<?php

Router::get('/','HomeController@home');
Router::get('/home','HomeController@home');

Router::get('/about','AboutController@index');

Router::get('/login','LoginController@index');
Router::post('/login/server','LoginController@server');
Router::get('/logout','LoginController@logout');

Router::get('/dashboard','DashboardController@dashboard');

Router::any('*', function () {
    echo '404 not found';
});