<?php
/**
 * Created by PhpStorm.
 * User: Maina
 * Date: 2/14/2018
 * Time: 11:34 AM
 */

function full_phone($phone)
{
    return preg_replace('/^07/', '2547', $phone);
}

function sms($recipients,$message)
{
    require_once(base_path('vendor/africastalking/africastalking/src/AfricasTalkingGateway.php'));
    $gateway    = new AfricasTalkingGateway(config('services.africa_t.username'), config('services.africa_t.app_key'));

    try
    {
        // Thats it, hit send and we'll take care of the rest.
        $results = $gateway->sendMessage($recipients, $message);
        return true;
    }
    catch ( AfricasTalkingGatewayException $e )
    {
        return false;
    }
}