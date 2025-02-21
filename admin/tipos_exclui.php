<?php
include 'acesso_com.php';
include '../conn/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $conn->query("DELETE FROM tipos WHERE id = $id ");

    //O if-else faz com que a página após mostrar a mensagem em JavaScript recarregue na página "original" após dar "ok".
    //Recarrega a página usuários_lista.php(original).
    if ($sql) {
        echo "<script>
            alert('Usuário deletado com sucesso!');
            window.location.href='tipos_lista.php';
          </script>";
    } else {
        echo "<script>
            alert('Erro ao deletar o usuário!');
            window.location.href='tipos_lista.php';
          </script>";
    }
}
?>

