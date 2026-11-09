<?php
$router->post('/login', 'AuthController@login');
$router->post('/registro', 'AuthController@registro');
$router->get('/sesion', 'AuthController@sesion');
$router->post('/logout', 'AuthController@logout');
//tarea 12 goofy momento