<?php
/**
 * Created by PhpStorm.
 * User: Maina
 * Date: 1/17/2018
 * Time: 3:38 PM
 */

namespace App\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'api_token' => $user->api_token
        ];
    }

}