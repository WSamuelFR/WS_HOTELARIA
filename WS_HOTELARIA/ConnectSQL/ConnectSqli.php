<?php

function Connect(): mysqli
{
    // Conexão ao banco de dados
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "hotel"; 

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    return($conn);

}


?>