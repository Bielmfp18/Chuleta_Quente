<?php 
include '../conn/connect.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cliente_cpf = $_POST['cliente_cpf'];
    $cliente_email = $_POST['cliente_email'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $motivo = $_POST['motivo'];
    $ativo = $_POST['ativo'];

    try {
        // Tenta inserir a reserva no banco de dados
        $tiporesult = $conn->query("INSERT INTO reserva (cliente_cpf, cliente_email, data, horario, motivo, ativo) 
        VALUES ('$cliente_cpf', '$cliente_email', '$data', '$horario', '$motivo', '$ativo')");

        if ($tiporesult) {
            // Mensagem de sucesso ao inserir uma reserva
            echo "<script>
            alert('Reserva concluída com sucesso!');
            window.location.href='reserva_lista.php';
          </script>";
        } else {
            // Mensagem de erro se não conseguir reservar
            echo "<script>
            alert('Erro ao tentar realizar a reserva. Detalhes: " . $conn->error . "');
            window.location.href='reserva_lista.php';
          </script>";
        }
    } catch (mysqli_sql_exception $e) {
        // Captura erro de entrada duplicada (código 1062)
        if ($e->getCode() == 1062) {
            echo "<script>  
            alert('Essa reserva já está cadastrada!');
            window.location.href='reserva_lista.php';
          </script>";
        } else {
            // Mostra o erro real gerado pelo banco de dados
            echo "<script>
            alert('Erro ao tentar reservar. Detalhes: " . $e->getMessage() . "');
            window.location.href='reserva_lista.php';
          </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Reserva</title>
</head>
<body>
    
<style>
/* Estilo básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-cadastro label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-cadastro input, .form-cadastro select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.form-cadastro button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-cadastro button:hover {
    background-color: #45a049;
}

.form-cadastro input[type="checkbox"] {
    width: auto;
    margin-right: 10px;
}

.form-cadastro input:focus, .form-cadastro select:focus {
    border-color: #4CAF50;
    outline: none;
}
</style>

<div class="container">
    <h2>Reserva</h2>
    <form action="" method="POST" class="form-cadastro">
        <!-- CPF -->
        <label for="cliente_cpf">CPF:</label>
        <input type="text" id="cliente_cpf" name="cliente_cpf" placeholder="Digite seu CPF" required>

        <!-- E-mail -->
        <label for="cliente_email">E-mail:</label>
        <input type="email" id="cliente_email" name="cliente_email" placeholder="Digite seu e-mail" required>
        
        <!-- Data -->
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>

        <!-- Horário -->
        <label for="horario">Horário:</label>
        <input type="time" id="horario" name="horario" required><br><br>

        <!-- Motivo -->
        <label for="motivo">Motivo:</label>
        <input type="text" id="motivo" name="motivo" placeholder="Digite seu motivo" required>
        
        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
