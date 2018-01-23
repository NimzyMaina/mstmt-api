<?php

namespace App\Http\Controllers\Api;

use App\Social;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login(Request $request,$provider)
    {
        // Validate the request
        $this->val($request->only('auth_token'),[
           'auth_token' => 'required'
        ]);

        $providers = ['facebook'];

        if(!in_array($provider,$providers))
        {
            return $this->respond('Unsupported Provider',400);
        }

        $user = Socialite::driver($provider)->userFromToken($request->auth_token);

        if(empty($user))
        {
            return $this->respond('Invalid Authorization Token',403);
        }

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', '=', $user->email)->first();

        $email = $user->email;

        if (!$user->email) {
            $email = 'missing' . str_random(10);
        }

        if (!empty($userCheck)) {

            $socialUser = $userCheck;

        }
        else {

            $sameSocialId = Social::where('social_id', '=', $user->id)
                ->where('provider', '=', $provider )
                ->first();

            if (empty($sameSocialId)) {

                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email = $email;
                $name = explode(' ', $user->name,2);

                if (count($name) >= 1) {
                    $newSocialUser->first_name = $name[0];
                }

                if (count($name) >= 2) {
                    $newSocialUser->last_name = $name[1];
                }

                $newSocialUser->password = bcrypt(str_random(16));
                $newSocialUser->api_token = str_random(64);
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);

                $socialUser = $newSocialUser;

            }
            else {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }
        }

        // successful login
        return $this->response->item($socialUser,new UserTransformer)->statusCode(200);


    }

    public function getSocialRedirect( $provider )
    {

        $providerKey = Config::get('services.' . $provider);

        if (empty($providerKey)) {

            return view('welcome')
                ->with('error','No such provider');

        }

        return Socialite::driver( $provider )->redirect();

    }
}
