<?php

function register($correo, $nombre, $contra, $fLasName, $mLastName, $birth, $logo, $gender){
    $res = true;

    $pattern = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/i";
    if(!preg_match($pattern, $correo))
        $res = false;
    
    $pattern = "/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/i";
    if(!preg_match($pattern, $contra))
        $res = false;
    
    $pattern = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
    if(!preg_match($pattern, $nombre))
        $res = false;
    if(!preg_match($pattern, $fLasName))
        $res = false;
    if(!preg_match($pattern, $mLastName))
        $res = false;

    if(empty($logo))
        $res = false;
    
    if(empty($gender))
        $res = false;

    $d1 = date("Y/m/d");
       /* 
    $diff = $birth->diff($d1);
    if($diff < 12)
        $res = false;*/

    return $res;
}


?>