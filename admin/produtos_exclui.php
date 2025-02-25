
<?php
include 'acesso_com.php';
include '../conn/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $conn->query("DELETE FROM produtos WHERE id = $id ");

    if ($sql) {
        echo "<script>
            alert('Produto deletado com sucesso!');
            window.location.href='produtos_lista.php';
          </script>";
    } else {
        echo "<script>
            alert('Erro ao deletar o produto!');
            window.location.href='produtos_exclui.php';
          </script>";
    }
}
?>
