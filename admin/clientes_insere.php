<?php
include 'acesso_com.php';
include '../conn/connect.php';

//if ($_SERVER["REQUEST_METHOD"] == "POST") ->  Evita q a mensagem de erro apareça quando eu recarregar a página.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome= $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
  

    try {
        // Tenta inserir o usuário no banco
        $tiporesult = $conn->query("INSERT INTO cliente VALUES (0, '$nome', '$email', $cpf)");

        if ($tiporesult) {
            // Mensagem de sucesso ao inserir um novo usuário.
            echo "<script>
            alert('Novo cliente inserido com sucesso!');
            window.location.href='tipos_lista.php';
          </script>";
        } else {
            // Mensagem de erro apenas se houver falha na inserção do usuário.
            echo "<script>
            alert('Erro ao tentar inserir o novo tipo.');
            window.location.href='tipos_insere.php';
          </script>";
        }
        //Essa parte do código utiliza um método/função chamada getCode() da classe Exception (subclasse: mysqli_sql_exception)
        // que captura um erro e o mostra ao usuário em seu código de verificação (exemplo: Para entradas duplicadas no Banco de Dados -> Código 1062).
    } catch (mysqli_sql_exception $e) {
        // Captura erro de entrada duplicada (código 1062) e exibe uma mensagem de erro.
        if ($e->getCode() == 1062) {
            echo "<script>
            alert('Este tipo já está cadastrado!');
            window.location.href='tipos_insere.php';
          </script>";
        } else {
           echo "<script>
            alert('Erro ao tentar inserir o novo tipo. Tente novamente!');
            window.location.href='tipos_insere.php';
          </script>";
        }
    }
}
?>