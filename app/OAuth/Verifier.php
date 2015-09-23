<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 8/16/15
 * Time: 21:28
 */

namespace CodeProject\OAuth;

use Illuminate\Support\Facades\Auth;

class Verifier
{

    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }

}