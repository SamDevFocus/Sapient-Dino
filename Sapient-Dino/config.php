<?php

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $database = "sapient_dino";

    $conexao = new mysqli($host, $user, $pass, $database);

    // teste de conexão do servidor
    //if($conexao->connect_errno){
    //    echo "ERRO";
    //}else{
    //    echo "Conexão efetuada com sucesso"; 
    //}

?>