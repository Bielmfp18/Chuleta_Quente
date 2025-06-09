<?php 

$host = "127.0.0.1"; //Ou localhost
$database = "tinsphpdb01";
$root = "root";
$pass = "";
$charset = "utf8";
$port = "3306";

//Todo bloco "try" termina com "catch".
try{
    //Lembre dessa variável quando usar um comando SQL no PHP.
    //"$conn" é um objeto da classe mysqli do tipo SQL.
    $conn = new mysqli($host, $root, $pass, $database, $port);
    //Declarando o utf8 através da variável "$charset".
    mysqli_set_charset($conn, $charset);
}
//Throwable é um objeto de excessão, a variável "$th" vai receber todos dados que deram erro durante o código.
catch(Throwable $th){
    die("Atenção rolou um ERRO, Cara! ".$th);
}
?>