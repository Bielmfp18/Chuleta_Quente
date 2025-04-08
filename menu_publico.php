<?php
session_start();
$nivel = $_SESSION['nivel_usuario'] ?? '';
?>
<!-- BOOTSTRAP -->
<!-- abre a barra de navegação -->
<style>
    .li-separador {
        margin-top: 7px;
        margin-left: 20px;
        margin-right: 20px;
    }

    .reserva1 {
        background-color: #0056b3 !important;
        color: white !important;
        border-radius: 10px;
        border: none;
        padding: 7px 10px !important;
        font-size: 18px !important;
        transition: 0.3s ease;
        cursor: pointer;
        display: inline-block;
    }

    .reserva1:hover {
        transform: scale(1.05);
        background-color: white !important;
        color: black !important;
        text-decoration: none;
    }

    .reserva1:visited {
        color: white;
    }
</style>

<nav class="navbar navbar-expanded-md navbar-fixed-top navbar-light navbar-inverse">
    <div class="container-fluid">
        <!-- agrupamento Mobile -->
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#menupublico" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">
                <img src="images/logo-chuleta.png" alt="Logotipo Chuleta Quente">
            </a>
        </div>
        <!-- Fecha agrupamento Mobile -->

        <!-- nav direita -->
        <div class="collapse navbar-collapse" id="menupublico">
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a href="index.php">
                        <span class="glyphicon glyphicon-home"></span>
                    </a>
                </li>
                <li><a href="index.php#destaques">DESTAQUES</a></li>
                <li><a href="index.php#produtos">PRODUTOS</a></li>

                <!-- Dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        TIPOS
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($rows_tipos as $row) { ?>
                            <li>
                                <a href="produtos_por_tipo.php?id_tipo=<?php echo $row[0] . '&rotulo=' . $row[2]; ?>">
                                    <?php echo $row[2]; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Fim do dropdown -->

                <li><a href="index.php#contato">CONTATO</a></li>

                <!-- Botão Pedido de Reserva -->
                <li class="li-separador">
                    <a href="../modelophp/cliente/pedido_reserva_cliente.php" class="reserva1">Pedido de Reserva</a>
                </li>

                <!-- início formulário de busca -->
                <form action="produtos_busca.php" method="get" name="form-busca" id="form-busca" class="navbar-form navbar-left" role="search">
                    <div class="input-group">
                        <input type="search" name="buscar" id="buscar" size="9" class="form-control" aria-label="search" placeholder="Buscar produto" minlength="3" required>
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Link de Login / Área do Usuário -->
                <li>
                    <?php if ($nivel === 'sup'): ?>
                        <a class="glyphicon glyphicon-user" href="/../modelophp/admin/index.php">&nbsp;ADMIN</a>
                    <?php elseif ($nivel === 'com'): ?>
                        <a class="glyphicon glyphicon-user" href="/../modelophp/cliente/index.php">&nbsp;MINHA ÁREA</a>
                    <?php else: ?>
                        <a class="glyphicon glyphicon-user" href="/../modelophp/admin/login.php">&nbsp;LOGIN</a>
                    <?php endif; ?>
                </li>



            </ul>
        </div>
    </div>
</nav>