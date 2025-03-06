<?php
include 'acesso_com.php';
include '../conn/connect.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];
 

    $sqlcliente = $conn->query("DELETE FROM cliente WHERE usuario_id = $id ");
    
    $sqluser = $conn->query("DELETE FROM usuarios WHERE id = $id ");
    



    //O if-else faz com que a página após mostrar a mensagem em JavaScript recarregue na página "original" após dar "ok".
    //Recarrega a página usuários_lista.php(original).
    if ($sqluser&&$sqlcliente) {
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

