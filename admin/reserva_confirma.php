<?php
include "../conn/connect.php";

$id = $_GET['id'];

// Atualiza a reserva para inativar
$result = $conn->query("UPDATE reserva SET ativo = 1 WHERE id = $id");

if ($result) {
    echo "<script>
            alert('Reserva confirmada com sucesso!');
            window.location.href='reserva_lista.php';
          </script>";
} else {
    echo "<script>
            alert('Erro ao confirmar a reserva.');
            window.location.href='reserva_lista.php';
          </script>";
}
?>
