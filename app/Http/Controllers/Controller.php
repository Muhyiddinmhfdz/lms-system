<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    protected function validationErrorsToString($errArray) {
        $valArr = array();
        foreach ($errArray->toArray() as $key => $value) { 
            // $errStr = $key.', '.$value[0];
            $errStr = $value[0];
            array_push($valArr, $errStr);
        }
        if(!empty($valArr)){
            $errStrFinal = implode('<br/> ', $valArr);
        }
        return $errStrFinal;
    }
}
