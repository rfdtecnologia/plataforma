<?php    
    function validaRequerido($valor){
        if(trim($valor) == ''){
            return false;
        }else{
            return true;
        }
    }
    function validarEntero($valor){
        if(filter_var($valor, FILTER_VALIDATE_INT) === 0 || !filter_var($valor, FILTER_VALIDATE_INT) === FALSE){
            return true;
        }else{
            return false;
        }
    }
    function validaEmail($valor){
        if(filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE){
            return false;
        }else{
            return true;
        }
    }
?>