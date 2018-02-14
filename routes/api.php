<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->group(['prefix' => 'v1'], function ($api) {

    $api->post('login/{provider}','LoginController@login');
    $api->get('login/{provider}','LoginController@login');

    $api->get('social/redirect/{provider}','LoginController@getSocialRedirect');

    $api->post('upload','UploadsController@upload');

    $api->get('statements','UploadsController@statements');

    $api->get('stk','MpesaController@stk');

    $api->post('callback','MpesaController@callback');

    $api->get('register','MpesaController@registerUrl');

});