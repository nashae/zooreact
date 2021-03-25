<?php 

class Securite 
{
    public static function secureHTML($string)
    {
        return htmlentities($string);
    }

    public static function verifAccessSession()
    {
        return (!empty($_SESSION['access']) && $_SESSION['access'] === 'admin');
    }
}