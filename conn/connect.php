<?php 

$host = "sql102.infinityfree.com"; //Ou localhost
$database = "chuleta-quente";
$user = "if0_39054069";
$pass = "pPWamFJPmaUX";
$charset = "utf8";
$port = "3306";

//Todo bloco "try" termina com "catch".
try{
    //Lembre dessa variável quando usar um comando SQL no PHP.
    //"$conn" é um objeto da classe mysqli do tipo SQL.
    $conn = new mysqli($host, $user, $pass, $database, $port);
    //Declarando o utf8 através da variável "$charset".
    mysqli_set_charset($conn, $charset);
   
    //Teste para a conexão com Banco de Dados.
    # echo "connect right";
}
//Throwable é um objeto de excessão, a variável "$th" vai receber todos dados que deram erro durante o código.
catch(Throwable $th){
    die("Atenção rolou um ERRO, Cara! ".$th);
}
?>

