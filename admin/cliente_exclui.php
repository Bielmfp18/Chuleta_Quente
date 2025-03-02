<?php
include 'acesso_com.php';
include '../conn/connect.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $idcliente = $_GET['usuario_id'];

    $sqluser = $conn->query("DELETE FROM usuarios WHERE id = $id ");


    $sqlcliente = $conn->query("DELETE FROM cliente WHERE usuario_id = $idcliente ");


    //O if-else faz com que a página após mostrar a mensagem em JavaScript recarregue na página "original" após dar "ok".
    //Recarrega a página usuários_lista.php(original).
    if ($sqlcliente && $sqluser) {
        echo "<script>
            alert('Cliente deletado com sucesso!');
            window.location.href='cliente_lista.php';
          </script>";
    } else {
        echo "<script>
            alert('Erro ao deletar o cliente!');
            window.location.href='cliente_lista.php';
          </script>";
    }
}
?>

