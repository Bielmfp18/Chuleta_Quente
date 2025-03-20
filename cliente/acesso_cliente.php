<?php 
include "../StayFit-Web/conn/connection.php";
include '../StayFit-Web/aluno/acesso_aluno.php';

// Seleciona o nível do usuário logado.
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = 1; // Valor padrão caso nenhum id seja informado
}
$sql_nivel = "SELECT * FROM nivel WHERE id = :id";
$stmt = $conn->prepare($sql_nivel);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$nivel = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['sigla'] == 'ALN') {
  header('Location: ../aluno/index.php');
  exit();
} elseif ($_SESSION['sigla'] == 'ADM') {
  header('Location: ../admin/index.php');
  exit();
}
?>

<style>
  .li-separador {
    margin-top: 7px;
    margin-left: 20px;
    margin-right: 20px;
  }

  .reserva1 {
    background-color: #C1FF72 !important;
    color: black!important;
    border-radius: 10px;
    border: none;
    padding: 7px 10px !important;
    font-size: 18px !important;
    transition: 0.3s ease;
    cursor: pointer;
    display: inline-block;
    text-decoration: none !important;
  }

  .reserva1:hover {
    transform: scale(1.05);
    background-color: #BD8AFD !important;
    color: #C1FF72 !important;
  }

  .reserva1:visited {
    color: white;
  }

  .big-icon {
    font-size: 2rem; 
  }
</style>

<nav class="navbar navbar-expand-lg" style="background-color: #000000;">
  <div class="container-fluid">

    <a href="index.php" class="navbar-brand ms-5">
      <img src="../StayFit-Web/imagens/LogoStayFitWeb88.png" alt="Logotipo">
    </a>

    <!-- Link com o ícone que redireciona de acordo com o tipo de usuário -->
    <a class="Area-nav" aria-current="page" href="<?php echo ($_SESSION['sigla'] == 'ADM') ? '../admin/index.php' : '../aluno/index.php'; ?>">
      <i class="bi bi-person-circle big-icon"></i> 
    </a>

    <li class="Area-nav">
      <?php 
      $login = ($_SESSION['sigla'] == 'ADM') ? $_SESSION['login_admin'] : $_SESSION['login_aluno'];
      echo $login; 
      ?>
    </li>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="bi bi-house" aria-current="page" href="../index.php">
            Início
          </a>
        </li>

        <li class="nav-item">
          <a class="bi bi-bookmark-star-fill" href="planos_lista.php">Planos</a>
        </li>

        <li class="nav-item">
          <a class="bi bi-people" href="alunos_lista.php">Sobre</a>
        </li>

        <li class="nav-item active mx-4 my-auto">
          <a href="buscar_academia.php" class="reserva1">Buscar Academia</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-light" href="../StayFit-Web/aluno/logout_aluno.php">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>

      </ul>
    </div>
  </div>

  <!-- icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</nav>
