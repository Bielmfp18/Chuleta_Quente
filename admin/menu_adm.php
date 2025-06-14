<?php include 'acesso_com.php';?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">    
<nav class="nav navbar-inverse">
    <div class="container-fluid">
        <!-- Agrupamento para exibição Mobile -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar" aria-expanded="false">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">
                <img src="../images/logo-chuleta.png" alt="">
            </a>
        </div>
        <!-- Fecha Agrupamento para exibição Mobile -->
        <!-- nav direita -->
        <div class="collapse navbar-collapse" id="defaultNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <button type="button" class="btn btn-danger navbar-btn disabled" style="cursor: default; margin-top: 10px; margin-right: 10px;">
                        Olá, <?php echo($_SESSION['login_usuario']); ?>!
                    </button>
                </li>
                <li class="active"><a href="index.php">ADMIN</a></li>
                <li><a href="produtos_lista.php">PRODUTOS</a></li>
                <li><a href="tipos_lista.php">TIPOS</a></li>
                <li><a href="usuarios_lista.php">USUÁRIOS</a></li>
                <li><a href="cliente_lista.php">CLIENTES</a></li>
                <li><a href="reserva_lista.php">RESERVAS</a></li>
                <li class="active">
                    <a href="../index.php">
                      <span class="glyphicon glyphicon-home"></span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <span class="glyphicon glyphicon-log-out"></span>
                    </a>
                </li>
            </ul>
        </div><!-- fecha collapse navbar-collapse -->
        <!-- Fecha nav direita -->

    </div><!-- fecha container-fluid -->
</nav>