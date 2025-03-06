<?php
include "../conn/connect.php";

$id = $_GET['id'];

// Atualiza a reserva para inativar
$result = $conn->query("UPDATE reserva SET ativo = 0 WHERE id = $id");

if ($result) {
    echo "<script>
            alert('Reserva desativada com sucesso!');
            window.location.href='reserva_lista.php';
          </script>";
} else {
    echo "<script>
            alert('Erro ao desativar a reserva.');
            window.location.href='reserva_lista.php';
          </script>";
}
?>
