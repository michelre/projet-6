<?php

namespace Projet6\Services;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class SessionService
{

    function isClientAuthorized()
    {
        if(!isset($_COOKIE['projet6'])) {
            return false;
        }
        try {
            JWT::decode($_COOKIE['projet6'], file_get_contents('certs/jwt.pub'), ['RS256']);
            return true;
        } catch (ExpiredException $e){
         return false;
        }
    }

    function storeCookie()
    {
        $token = array(
            "iss" => "normandhelp",
            "iat" => time(),
            "exp" => time() + 3600
        );
        $jwt = JWT::encode($token, file_get_contents('certs/jwt.key'), 'RS256');
        setcookie('projet6', $jwt); // Stock un cookie qui contient le temps d'expiration
    }

    function disconnect()
    {
        setcookie('projet6', 'connexion-pr6', time() - 1);
    }

}
