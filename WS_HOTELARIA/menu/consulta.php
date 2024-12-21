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
            <h2>Consulta de hospedes e empresas</h2>
            <nav class="nav justify-content-center mt-3">
                <button id="menuButton" class="nav-link btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    Menu <i class="fas fa-bars"></i>
                </button>
                <a href="clientes.php" class="nav-link btn btn-light border">Cadastro</a>
                <a href="consulta.php" class="nav-link btn btn-light border">Consulta</a>
            </nav>
        </div>
    </header>

    <!-- Offcanvas minimizado com botões e ícones -->
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
        <!-- Tabs for Hóspedes and Empresas -->
        <ul class="nav nav-tabs" id="consultasTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hospede-tab" data-bs-toggle="tab" data-bs-target="#hospede" type="button" role="tab" aria-controls="hospede" aria-selected="true">Hóspede</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="empresa-tab" data-bs-toggle="tab" data-bs-target="#empresa" type="button" role="tab" aria-controls="empresa" aria-selected="false">Empresa</button>
            </li>
        </ul>

        <div class="tab-content" id="consultasTabContent">
            <!-- Hóspedes Tab -->
            <div class="tab-pane fade" id="hospede" role="tabpanel" aria-labelledby="hospede-tab">
                <form method="GET" class="d-flex mb-3">
                    <input type="text" name="hospede_search" class="form-control" placeholder="Buscar Hóspede por Nome ou CPF">
                    <input type="hidden" name="active_tab" value="hospede"> <!-- Campo oculto -->
                    <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                </form>

                <div class="row" id="hospedeCards">
                    <?php
                    // Configuração do banco de dados
                    require('../ConnectSQL/ConnectSqli.php');

                    // Criando a conexão
                    $conn = Connect();

                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                    // Busca de Hóspedes
                    $hospede_search = $_GET['hospede_search'] ?? '';
                    $query = "SELECT * FROM hospedes WHERE first_name LIKE '%$hospede_search%' OR cpf LIKE '%$hospede_search%'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
                                        <p class="card-text"><strong>CPF:</strong> <?php echo $row['cpf']; ?></p>
                                    </div>
                                    <div class="card-footer text-right">
                                        <a href="../hospede/atualize_hospede.php?cpf=<?php echo $row['cpf']; ?>" class="btn btn-outline-primary">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>Nenhum hóspede encontrado.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Empresas Tab -->
            <div class="tab-pane fade" id="empresa" role="tabpanel" aria-labelledby="empresa-tab">
                <form method="GET" class="d-flex mb-3">
                    <input type="text" name="empresa_search" class="form-control" placeholder="Buscar Empresa por Nome ou CNPJ">
                    <input type="hidden" name="active_tab" value="empresa"> <!-- Campo oculto -->
                    <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                </form>
                <div class="row" id="empresaCards">
                    <?php
                    // Busca de Empresas
                    $empresa_search = $_GET['empresa_search'] ?? '';
                    $query_empresa = "SELECT * FROM empresa WHERE company_name LIKE '%$empresa_search%' OR cnpj LIKE '%$empresa_search%'";
                    $result_empresa = $conn->query($query_empresa);

                    if ($result_empresa->num_rows > 0) {
                        while ($row_empresa = $result_empresa->fetch_assoc()) {
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row_empresa['company_name']; ?></h5>
                                        <p class="card-text"><strong>CNPJ:</strong> <?php echo $row_empresa['cnpj']; ?></p>
                                    </div>
                                    <div class="card-footer text-right">
                                        <a href="../Empresa/atualize_empresa.php?cnpj=<?php echo $row_empresa['cnpj']; ?>" class="btn btn-outline-primary">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>Nenhuma empresa encontrada.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab') || 'hospede';

            const hospedeTab = document.getElementById('hospede-tab');
            const hospedeContent = document.getElementById('hospede');
            const empresaTab = document.getElementById('empresa-tab');
            const empresaContent = document.getElementById('empresa');

            if (activeTab === 'empresa') {
                empresaTab.classList.add('active');
                empresaContent.classList.add('show', 'active');
                hospedeTab.classList.remove('active');
                hospedeContent.classList.remove('show', 'active');
            } else {
                hospedeTab.classList.add('active');
                hospedeContent.classList.add('show', 'active');
                empresaTab.classList.remove('active');
                empresaContent.classList.remove('show', 'active');
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