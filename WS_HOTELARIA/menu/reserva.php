<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cadastro de Reserva e Quartos</title>
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

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            border-radius: 5px;
        }

        /* Ajustes de estilo para o menu minimizado */
        .offcanvas {
            margin-top: 177px;
            background-color: #ffcc00;
            /* Cor de fundo escura */
            color: #0056b3;
            /* Cor do texto */
            width: 250px;
        }

        .offcanvas-minimized {
            margin-top: 177px;
            width: 70px;
            overflow-x: hidden;
        }

        .offcanvas a {
            color: #f8f9fa;
            /* Cor dos links */
        }

        .offcanvas a:hover {
            color: #ffc107;
            /* Cor dos links ao passar o mouse */
        }

        .offcanvas-header {
            border-bottom: 1px solid #495057;
            /* Linha de separação */
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
    </style>
</head>

<body>

    <header>
        <div class="container text-center">
            <h1>WS-HOTELARIA</h1>
            <h2>Cadastro de Hospedagem e Quartos</h2>
            <nav class="nav justify-content-center mt-3">
                <button id="menuButton" class="nav-link btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    Menu <i class="fas fa-bars"></i>
                </button>
                <a href="reserva.php" class="nav-link btn btn-light border">Cadastro</a>
                <a href="quarto.php" class="nav-link btn btn-light border">Consulta</a>
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
        <article>
            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="reserva-tab" data-bs-toggle="tab" data-bs-target="#reserva" type="button" role="tab" aria-controls="reserva" aria-selected="true">Hospedagem</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="quarto-tab" data-bs-toggle="tab" data-bs-target="#quarto" type="button" role="tab" aria-controls="quarto" aria-selected="false">Quarto</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="reserva" role="tabpanel" aria-labelledby="reserva-tab">
                    <!-- Conteúdo da aba Reserva -->
                    <div class="container mt-4">
                        <form action="../reserva/inserir_reserva.php" method="POST">
                            <fieldset class="border p-3 mb-4">
                                <h2 class="text-center">Cadastro de Hospedagem</h2>

                                <!-- Switch para alternar entre Empresas e Hóspedes -->
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="toggleSwitch" onchange="toggleDatalist()">
                                    <label class="form-check-label" for="toggleSwitch">Alternar entre Hóspedes e Empresas</label>
                                </div>

                                <!-- CPF do Hóspede Principal / Empresa -->
                                <div class="mb-3">
                                    <label for="titular" class="form-label" id="datalistLabel">Reservado por: CPF do Hóspede</label>
                                    <input list="dynamicList" class="form-control" id="titular" name="hospede_cpf" required>
                                    <datalist id="dynamicList">
                                        <!-- Dados iniciais de Hóspedes -->
                                        <?php
                                        include('../ConnectSQL/ConnectSqli.php');
                                        $conn = Connect();
                                        $hospedesQuery = "SELECT cpf, CONCAT(first_name, ' ', last_name) AS nome FROM hospedes";
                                        $hospedesResult = $conn->query($hospedesQuery);
                                        while ($row = $hospedesResult->fetch_assoc()) {
                                            echo '<option value="' . $row['cpf'] . '">' . $row['nome'] . '</option>';
                                        }
                                        ?>
                                    </datalist>
                                </div>

                    </div>
                    <div class="container mt-4">

                        <!-- Hóspede Principal -->
                        <div class="mb-3">
                            <label for="hospede_one" class="form-label">CPF do Hóspede Principal</label>
                            <input list="hospedes" class="form-control" id="hospede_one" name="hospede_one" required>
                            <datalist id="hospedes">
                                <?php
                                $query = "SELECT cpf, CONCAT(first_name, ' ', last_name) AS nome FROM hospedes";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['cpf'] . '">' . $row['nome'] . '</option>';
                                }
                                ?>
                            </datalist>
                        </div>


                        <!-- Hóspede Opcional 2 -->
                        <div class="mb-3">
                            <label for="hospede_two" class="form-label">CPF do Hóspede Opcional 2</label>
                            <input list="hospedes" class="form-control" id="hospede_two" name="hospede_two">
                        </div>

                        <!-- Hóspede Opcional 3 -->
                        <div class="mb-3">
                            <label for="hospede_three" class="form-label">CPF do Hóspede Opcional 3</label>
                            <input list="hospedes" class="form-control" id="hospede_three" name="hospede_three">
                        </div>

                        <!-- Hóspede Opcional 4 -->
                        <div class="mb-3">
                            <label for="hospede_four" class="form-label">CPF do Hóspede Opcional 4</label>
                            <input list="hospedes" class="form-control" id="hospede_four" name="hospede_four">
                        </div>


                        <!-- Número do Quarto -->
                        <div class="mb-3">
                            <label for="quarto_number" class="form-label">Número do Quarto</label>
                            <select class="form-select" id="quarto_number" name="quarto_number" required>
                                <option value="" disabled selected>Selecione um quarto</option>
                                <?php
                                $query = "SELECT number_room, bed_quantity, room_status FROM quarto";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['number_room'] . '">Número: ' . $row['number_room'] . ' - ' . $row['bed_quantity'] . ' - ' . ucfirst($row['room_status']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <!-- Restante do formulário -->
                        <div class="mb-3">
                            <label for="data_checkin" class="form-label">Data de Check-in</label>
                            <input type="date" class="form-control" id="data_checkin" name="data_checkin" required>
                        </div>

                        <div class="mb-3">
                            <label for="data_checkout" class="form-label">Data de Check-out</label>
                            <input type="date" class="form-control" id="data_checkout" name="data_checkout" required>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total (R$)</label>
                            <input type="number" class="form-control" id="total" name="total" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control" id="observacoes" name="observacoes"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="situacao" class="form-label">Situação</label>
                            <select class="form-select" id="situacao" name="situacao" required>
                                <option value="ativa">Ativa</option>
                                <option value="encerrada">Encerrada</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="usuario_responsavel" class="form-label">Usuário Responsável</label>
                            <input type="text" class="form-control" id="usuario_responsavel" name="usuario_responsavel" required>
                        </div>
                        </fieldset><br><br>

                        <center>
                            <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Cadastrar Reserva</button>
                        </center>
                        </form>
                    </div>
                    <script>
                        function toggleDatalist() {
                            const toggleSwitch = document.getElementById('toggleSwitch');
                            const datalistLabel = document.getElementById('datalistLabel');
                            const titularInput = document.getElementById('titular');
                            const dynamicList = document.getElementById('dynamicList');

                            // Limpar opções do datalist
                            dynamicList.innerHTML = '';

                            if (toggleSwitch.checked) {
                                // Modo Empresa - Alterar para CNPJ
                                datalistLabel.textContent = 'Reservado por: CNPJ da Empresa';
                                titularInput.setAttribute('name', 'empresa_cnpj');

                                <?php
                                // PHP para obter empresas e gerar opções JS
                                $empresasQuery = "SELECT cnpj, company_name FROM empresa";
                                $empresasResult = $conn->query($empresasQuery);
                                $empresaOptions = [];
                                while ($row = $empresasResult->fetch_assoc()) {
                                    $empresaOptions[] = "<option value='{$row['cnpj']}'>{$row['company_name']}</option>";
                                }
                                ?>

                                // Inserir opções de empresa no datalist
                                dynamicList.innerHTML = <?php echo json_encode(implode('', $empresaOptions)); ?>;
                            } else {
                                // Modo Hóspede - Alterar para CPF
                                datalistLabel.textContent = 'Reservado por: CPF do Hóspede';
                                titularInput.setAttribute('name', 'hospede_cpf');

                                <?php
                                // PHP para obter hóspedes e gerar opções JS
                                $hospedeOptions = [];
                                $hospedesResult = $conn->query($hospedesQuery); // Executa novamente a consulta para hospedes
                                while ($row = $hospedesResult->fetch_assoc()) {
                                    $hospedeOptions[] = "<option value='{$row['cpf']}'>{$row['nome']}</option>";
                                }
                                ?>

                                // Inserir opções de hóspede no datalist
                                dynamicList.innerHTML = <?php echo json_encode(implode('', $hospedeOptions)); ?>;
                            }
                        }
                    </script>
                </div>
                <div class="tab-pane fade" id="quarto" role="tabpanel" aria-labelledby="quarto-tab">
                    <!-- Conteúdo da aba Quarto -->
                    <div class="container mt-4">
                        <h2 class="text-center">Cadastro de Quarto</h2>
                        <form action="../quarto/inserir_quarto.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="room_number" class="form-label">Número do Quarto</label>
                                    <input type="number" class="form-control" id="room_number" name="room_number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bed_quantity" class="form-label">Quantidade de Camas</label>
                                    <select class="form-control" id="bed_quantity" name="bed_quantity" required>
                                        <option value="single">Single</option>
                                        <option value="duplo">Duplo</option>
                                        <option value="triplo">Triplo</option>
                                        <option value="quaduplo">Quádruplo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="room_type" class="form-label">Tipo de Quarto</label>
                                <select class="form-control" id="room_type" name="room_type" required>
                                    <option value="ar-condicionado">Ar-Condicionado</option>
                                    <option value="ventilador">Ventilador</option>
                                </select>
                            </div>
                            <center>
                                <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Cadastrar Quarto</button>
                            </center>
                        </form>
                    </div>
                </div>

        </article>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© 2024 WS-HOTELARIA. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybSiBqkPUNcGvR0jzF8p+1Up6D8tM5v6Xb3t6z4pGFE3z0hpn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Vs1B0B3hDdlDhFw7vFEXA9yZ9T6P6p0wW5jcQF6djKP17vH" crossorigin="anonymous"></script>
</body>

</html>