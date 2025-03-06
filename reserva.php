<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Link para CSS específico -->
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
    <title>Reserva</title>
    <style>
        .container2 {
            width: 100%;
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .btn-reserva {
            background-color: #0056b3 ;
            color: white !important;
            padding: 10px 20px ;
            border-radius: 10px;
            border: none;
            font-size: 18px;
            transition: 0.3s ease ;
            cursor: pointer;
            display: inline-block ;
        }

        .btn-reserva:hover {
            transform: scale(1.05) ;
            background-color: #ffcc00 ;
            color: white;
    
        }

        /* .btn-reserva:visited {
            color: white;
        } */

        .promo-banner {
            background-color: #ffcc00;
            color: black;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container2">
        <a href="../modelophp/cliente/pedido_reserva.php"  style = "text-decoration: none;" class="btn-reserva">Fazer Reserva</a>
    </div>

    <div class="promo-banner">
        Faça sua reserva e ganhe 70% de desconto no rodízio e 10% de desconto nas bebidas para reservas com mais de 5 pessoas!
    </div>

</body>

</html>