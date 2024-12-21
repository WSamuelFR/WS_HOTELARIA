<?php
require('../ConnectSQL/ConnectSqli.php');
$conn = Connect();

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quarto_number = $_POST['quarto_number'];
    $reserva_id = $_POST['reserva_id'] ?? null;

    // Verifica se o quarto tem reservas ativas
    $data_atual = date('Y-m-d');
    $hora_atual = date('H:i:s');

    if ($reserva_id) {
        // Atualiza a reserva como encerrada e limpa o quarto
        $update_reserva = "UPDATE reserva_quarto SET situacao='encerrada' WHERE reserva_id=$reserva_id";
        $update_quarto = "UPDATE quarto SET clean_status='limpo', room_status='livre' WHERE number_room=$quarto_number";

        if ($conn->query($update_reserva) && $conn->query($update_quarto)) {
            echo "<script>
                    alert('Quarto limpo com sucesso! Reserva encerrada.');
                    window.location.href = 'sua_pagina_quartos.php'; // Redirecione para a página dos quartos
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao atualizar a reserva ou limpar o quarto.');
                    window.location.href = 'sua_pagina_quartos.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Erro: Reserva não encontrada ou quarto não pode ser limpo.');
                window.location.href = 'sua_pagina_quartos.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Consultas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e7f1ff;
        }

        header {
            background: #ffcc00;
            color: #0056b3;
            padding: 20px 0;
            border-bottom: #77d7ff 3px solid;
        }

        header h1 {
            color: #0056b3;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 24px;
        }

        header nav .nav-link {
            color: #0056b3;
            font-weight: bold;
        }

        header nav .nav-link:hover {
            color: #e6b800;
        }

        .tab-content {
            padding: 20px;
            background: #fff;
            border: 1px solid #77d7ff;
            margin-top: 20px;
            border-radius: 8px;
        }

        .nav-tabs .nav-link.active {
            background-color: #e6b800;
            color: #0056b3;
            border-color: #77d7ff #77d7ff #fff;
            font-weight: bold;
        }

        .btn {
            border-radius: 5px;
        }

        /* Ajustes de estilo para o menu minimizado */
        .offcanvas {
            margin-top: 177px;
            background-color: #ffcc00;
            color: #0056b3;
            width: 250px;
        }

        .offcanvas-minimized {
            margin-top: 177px;
            width: 70px;
            overflow-x: hidden;
        }

        .offcanvas a {
            color: #f8f9fa;
        }

        .offcanvas a:hover {
            color: #ffc107;
        }

        .offcanvas-header {
            border-bottom: 1px solid #495057;
        }

        .btn-icon {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            text-align: left;
        }

        .btn-icon i {
            font-size: 2.5rem;
            /* Ajuste o tamanho dos ícones */
        }

        .card {
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="container text-center">
        <h1>WS-HOTELARIA</h1>
            <h2>Consulta de hospedagens e quartos</h2>
            <nav class="nav justify-content-center mt-3">
                <button id="menuButton" class="nav-link btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    Menu <i class="fas fa-bars"></i>
                </button>
                <a href="reserva.php" class="nav-link btn btn-light border">Cadastro</a>
                <a href="quarto.php" class="nav-link btn btn-light border">Consulta</a>
            </nav>
        </div>
    </header>

    <div class="offcanvas offcanvas-start offcanvas-minimized" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Menu de Navegação</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <button class="nav-link btn btn-icon mb-2 btn-light border" onclick="window.location.href='clientes.php'">
                <i class="bi bi-person-plus">🪪</i>
                <span>Clientes</span>
            </button>
            <button class="nav-link btn btn-icon mb-2 btn-light border" onclick="window.location.href='reserva.php'">
                <i class="bi bi-search">📝</i>
                <span>Reservas</span>
            </button>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Tabs for Reservas and Quartos -->
        <ul class="nav nav-tabs" id="consultasTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reservas-tab" data-bs-toggle="tab" data-bs-target="#reservas" type="button" role="tab" aria-controls="reservas" aria-selected="true">Hospedagens</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="quartos-tab" data-bs-toggle="tab" data-bs-target="#quartos" type="button" role="tab" aria-controls="quartos" aria-selected="false">Quartos</button>
            </li>
        </ul>

        <div class="tab-content" id="consultasTabContent">
            <!-- Reservas Tab -->
            <div class="tab-pane fade" id="reservas" role="tabpanel" aria-labelledby="reservas-tab">
                <div class="container mt-4">
                    <form method="GET" class="d-flex mb-3">
                        <input type="text" name="reserva_search" class="form-control" placeholder="Buscar Reserva por CPF ou CNPJ">
                        <input type="hidden" name="active_tab" id="active_tab_reservas" value="reservas"> <!-- Campo oculto -->
                        <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                    </form>
                </div>

                <div class="row" style="overflow-y: auto;">
                    <?php
                    // Busca de Reservas
                    $reserva_search = $_GET['reserva_search'] ?? '';
                    $query_reservas = "SELECT * FROM reserva_quarto WHERE hospede_titular_cpf LIKE '%$reserva_search%' OR empresa_titular_cnpj LIKE '%$reserva_search%'";
                    $result = $conn->query($query_reservas);

                    $isReservaFound = false; // Variável para determinar se encontramos reservas
                    if ($result && $result->num_rows > 0) {
                        $isReservaFound = true; // Marca como encontrado
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Hospedagem #<?php echo $row['reserva_id']; ?></h5>
                                        <p class="card-text"><strong>Reservado por: </strong><?php echo $row['hospede_titular_cpf'] ?? $row['empresa_titular_cnpj']; ?></p>
                                        <p class="card-text"><strong>Data Check-in:</strong> <?php echo $row['data_checkin']; ?></p>
                                        <p class="card-text"><strong>Data Check-out:</strong> <?php echo $row['data_checkout']; ?></p>
                                        <p class="card-text"><strong>Situação:</strong> <?php echo ucfirst($row['situacao']); ?></p>
                                        <p class="card-text"><strong>Total:</strong> R$ <?php echo number_format($row['total'], 2, ',', '.'); ?></p>
                                    </div>
                                    <div class="card-footer text-right">
                                        <a href="../reserva/atualize_reserva.php?reserva_id=<?php echo $row['reserva_id']; ?>" class="btn btn-outline-primary">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>Nenhuma reserva encontrada.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Quartos Tab -->
            <div class="tab-pane fade" id="quartos" role="tabpanel" aria-labelledby="quartos-tab">
                <div class="container mt-4">
                    <form method="GET" class="d-flex mb-3">
                        <input type="text" name="quarto_search" class="form-control" placeholder="Buscar Quarto por Número ou tipo">
                        <input type="hidden" name="active_tab" id="active_tab_quartos" value="quartos"> <!-- Campo oculto -->
                        <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                    </form>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4" style="overflow-y: auto;">
                    <?php
                    // Inicializa a variável de busca
                    $quarto_search = $_GET['quarto_search'] ?? '';

                    // Prepara a consulta de quartos com busca dinâmica
                    $stmt_quartos = $conn->prepare("SELECT * FROM quarto WHERE number_room LIKE ? OR room_type LIKE ?");
                    $search_param = "%$quarto_search%";
                    $stmt_quartos->bind_param("ss", $search_param, $search_param);
                    $stmt_quartos->execute();
                    $resultquarto = $stmt_quartos->get_result();

                    $data_atual = date('Y-m-d');
                    $hora_atual = date('H:i:s');

                    if ($resultquarto && $resultquarto->num_rows > 0) {
                        while ($row = $resultquarto->fetch_assoc()) {
                            $quarto_number = $row['number_room'];
                            $room_status = $row['room_status'] ?? 'livre'; // Padrão: livre
                            $clean_status = $row['clean_status'] ?? 'sujo'; // Padrão: sujo
                            $reservaid = null;
                            $situacao_reserva = null;

                            // Consulta para verificar reservas ativas
                            $stmt_reserva = $conn->prepare(
                                "SELECT * FROM reserva_quarto 
                 WHERE quarto_number = ? 
                   AND ? BETWEEN data_checkin AND data_checkout"
                            );
                            $stmt_reserva->bind_param("is", $quarto_number, $data_atual);
                            $stmt_reserva->execute();
                            $result_reserva = $stmt_reserva->get_result();

                            if ($result_reserva && $result_reserva->num_rows > 0) {
                                $reserva = $result_reserva->fetch_assoc();
                                $reservaid = $reserva['reserva_id'] ?? null;
                                $situacao_reserva = $reserva['situacao'];

                                if ($situacao_reserva === 'ativa') {
                                    $room_status = 'ocupado';
                                } elseif (
                                    $situacao_reserva === 'encerrada' ||
                                    ($data_atual === $reserva['data_checkout'] && $hora_atual >= '12:00:00')
                                ) {
                                    $room_status = 'livre'; // Considera como livre para exibição
                                }
                            }

                            // Atualiza o status no banco de dados
                            $stmt_update = $conn->prepare("UPDATE quarto SET room_status = ?, clean_status = ? WHERE number_room = ?");
                            $stmt_update->bind_param("ssi", $room_status, $clean_status, $quarto_number);
                            $stmt_update->execute();

                            // Define a classe e exibição de status para o card
                            $status_class = ($room_status === 'ocupado') ? "card text-bg-danger mb-3" : "card text-bg-success mb-3";
                    ?>
                            <div class="col">
                                <div class="card h-100 <?php echo $status_class; ?>">
                                    <div class="card-header">
                                        <h3><?php echo htmlspecialchars($room_status); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Número: <?php echo htmlspecialchars($row['number_room']); ?></h5>
                                        <p class="card-text">Camas: <?php echo htmlspecialchars($row['bed_quantity']); ?></p>
                                        <p class="card-text">Tipo: <?php echo htmlspecialchars($row['room_type']); ?></p>
                                    </div>
                                    <div class="card-footer text-right">
                                        <?php if ($situacao_reserva === 'ativa') { ?>
                                            <form action="quarto.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="quarto_number" value="<?php echo htmlspecialchars($quarto_number); ?>">
                                                <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reservaid); ?>">
                                                <button type="submit" class="btn btn-outline-dark" onclick="return confirm('Tem certeza que deseja encerrar?');">Limpar</button>
                                            </form>
                                        <?php } ?>
                                        <?php if ($reservaid && $room_status === 'ocupado') { ?>
                                            <a href="../reserva/atualize_reserva.php?reserva_id=<?php echo htmlspecialchars($reservaid);  ?>"><button class="btn btn-outline-dark">Reserva</button></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>Nenhum quarto encontrado.</p>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab') || 'reservas';

            const reservasTab = document.getElementById('reservas-tab');
            const reservasContent = document.getElementById('reservas');
            const quartosTab = document.getElementById('quartos-tab');
            const quartosContent = document.getElementById('quartos');

            if (activeTab === 'quartos') {
                quartosTab.classList.add('active');
                quartosContent.classList.add('show', 'active');
                reservasTab.classList.remove('active');
                reservasContent.classList.remove('show', 'active');
            } else {
                reservasTab.classList.add('active');
                reservasContent.classList.add('show', 'active');
                quartosTab.classList.remove('active');
                quartosContent.classList.remove('show', 'active');
            }
        });
    </script>




    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© 2024 WS-HOTELARIA. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybFf7k+S3S5wTA9S5a6+9X6VTVh0MoPr1u1cx6khHl0pT5EAX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFj7vFVVVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


</html>