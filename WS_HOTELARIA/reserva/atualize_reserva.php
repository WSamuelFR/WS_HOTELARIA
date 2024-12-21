<?php
session_start();
include('../ConnectSQL/ConnectSqli.php');
$conn = Connect();

// Verificar se 'reserva_id' foi passado corretamente via GET ou POST
if (isset($_GET['reserva_id'])) {
    $reserva_id = intval($_GET['reserva_id']);
} elseif (isset($_POST['reserva_id'])) {
    $reserva_id = intval($_POST['reserva_id']);
} else {
    die('Erro: reserva_id não fornecido.');
}

// Consultar os dados da reserva no banco
$reservaQuery = "SELECT * FROM reserva_quarto WHERE reserva_id = ?";
$stmt = $conn->prepare($reservaQuery);

// Verifique se a consulta foi preparada corretamente
if ($stmt === false) {
    die('Erro na preparação da consulta: ' . $conn->error);
}

$stmt->bind_param("i", $reserva_id);
$stmt->execute();

// Verifique se a execução foi bem-sucedida
$reservaResult = $stmt->get_result();
if ($reservaResult === false) {
    die('Erro na execução da consulta: ' . $stmt->error);
}

$reserva = $reservaResult->fetch_assoc();
if (!$reserva) {
    die('Erro: Nenhuma reserva encontrada com o ID fornecido.');
}

// Consultar hóspedes, empresas e quartos para popular os datalists
$hospedesQuery = "SELECT cpf, CONCAT(first_name, ' ', last_name) AS nome FROM hospedes";
$hospedesResult = $conn->query($hospedesQuery);

$quartosQuery = "SELECT number_room, bed_quantity FROM quarto";
$quartosResult = $conn->query($quartosQuery);

$empresasQuery = "SELECT cnpj, company_name FROM empresa";
$empresasResult = $conn->query($empresasQuery);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    </style>
</head>

<body>

    <?php if ($reserva): ?>
        <header>
            <div class="container text-center">
                <h1>HOTEL DA SERRA</h1>
                <h2>Editar Dados</h2>
                <nav class="nav justify-content-center mt-3">
                    <a href="imprimir_reserva.php?reserva_id=<?php echo $reserva['reserva_id']; ?>" class="nav-link btn btn-light border">Baixar pdf</a>
                    <a href="../menu/quarto.php" class="nav-link btn btn-light border">Voltar</a>
                </nav>
            </div>
        </header>

        <div class="container mt-4">
            <article>
                <div class="tab-content">
                    <form action="update_reserva.php" method="POST">
                        <!-- Informações Gerais -->
                        <fieldset class="border p-3 mb-4">
                            <legend class="w-auto px-2">Informações Gerais</legend>
                            <div class="row">
                                <div class="container">
                                    <h2 class="text-center">Editar Reserva</h2>

                                    <!-- Switch para alternar entre Empresas e Hóspedes -->

                                    <!-- CPF/CNPJ do Hóspede Principal / Empresa -->
                                    <div class="mb-3">
                                        <label for="titular" class="form-label" id="datalistLabel">Reservado por: CPF / CNPJ</label>
                                        <input list="dynamicList" class="form-control" id="titular" name="hospede_cpf" value="<?php echo $reserva['hospede_titular_cpf'] ?: $reserva['empresa_titular_cnpj']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="container">



                                    <!-- CPF do Hóspede Principal -->
                                    <div class="mb-3">
                                        <label for="hospede_one" class="form-label">CPF do Hóspede Principal</label>
                                        <input list="hospedes" class="form-control" id="hospede_one" name="hospede_one" value="<?php echo $reserva['hospede_one']; ?>" required>
                                        <datalist id="hospedes">
                                            <?php
                                            while ($row = $hospedesResult->fetch_assoc()) {
                                                echo '<option value="' . $row['cpf'] . '">' . $row['nome'] . '</option>';
                                            }
                                            ?>
                                        </datalist>
                                    </div>

                                    <!-- Hóspede Opcional 2 -->
                                    <div class="mb-3">
                                        <label for="hospede_two" class="form-label">CPF do Hóspede Opcional 2</label>
                                        <input list="hospedes" class="form-control" id="hospede_two" name="hospede_two" value="<?php echo $reserva['hospede_two']; ?>">
                                    </div>

                                    <!-- Hóspede Opcional 3 -->
                                    <div class="mb-3">
                                        <label for="hospede_three" class="form-label">CPF do Hóspede Opcional 3</label>
                                        <input list="hospedes" class="form-control" id="hospede_three" name="hospede_three" value="<?php echo $reserva['hospede_three']; ?>">
                                    </div>

                                    <!-- Hóspede Opcional 4 -->
                                    <div class="mb-3">
                                        <label for="hospede_four" class="form-label">CPF do Hóspede Opcional 4</label>
                                        <input list="hospedes" class="form-control" id="hospede_four" name="hospede_four" value="<?php echo $reserva['hospede_four']; ?>">
                                    </div>

                                    <!-- Número do Quarto -->
                                    <div class="mb-3">
                                        <label for="quarto_number" class="form-label">Número do Quarto</label>
                                        <select class="form-select" id="quarto_number" name="quarto_number" readonly>
                                            <option value="" disabled>Selecione um quarto</option>
                                            <?php
                                            while ($row = $quartosResult->fetch_assoc()) {
                                                $selected = ($row['number_room'] == $reserva['quarto_number']) ? 'selected' : '';
                                                echo '<option value="' . $row['number_room'] . '" ' . $selected . '>';
                                                echo $row['number_room'] . ' - ' . $row['bed_quantity'] . ' camas';
                                                echo '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <!-- Restante do formulário -->
                                    <div class="mb-3">
                                        <label for="data_checkin" class="form-label">Data de Check-in</label>
                                        <input type="date" class="form-control" id="data_checkin" name="data_checkin" value="<?php echo $reserva['data_checkin']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="data_checkout" class="form-label">Data de Check-out</label>
                                        <input type="date" class="form-control" id="data_checkout" name="data_checkout" value="<?php echo $reserva['data_checkout']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="total" class="form-label">Total (R$)</label>
                                        <input type="number" class="form-control" id="total" name="total" step="0.01" value="<?php echo $reserva['total']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="observacoes" name="observacoes"><?php echo $reserva['observacoes']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="situacao" class="form-label">Situação</label>
                                        <select class="form-select" id="situacao" name="situacao" required>
                                            <option value="ativa" <?php echo $reserva['situacao'] == 'ativa' ? 'selected' : ''; ?>>Ativa</option>
                                            <option value="encerrada" <?php echo $reserva['situacao'] == 'encerrada' ? 'selected' : ''; ?>>Encerrada</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="usuario_responsavel" class="form-label">Usuário Responsável</label>
                                        <input type="text" class="form-control" id="usuario_responsavel" name="usuario_responsavel" value="<?php echo $reserva['usuario_responsavel']; ?>" readonly>
                                    </div>

                                    <input type="hidden" class="form-control" id="reserva_id" name="reserva_id" value="<?php echo $reserva['reserva_id']; ?>" readonly>


                                </div>
                            </div>
                        </fieldset>

                        <!-- Botão de Envio -->
                        <?php if ($reserva['situacao'] == 'encerrada') { ?>
                            <center>
                                <input type="text" value="Encerrada" class="btn btn-outline-primary" readonly>
                            </center>

                        <?php } else { ?>
                            <center>
                                <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Salvar alterações</button>
                            </center>

                        <?php } ?>

                    </form>

                <?php else: ?>
                    <p class="text-center">Registro não encontrado.</p>
                <?php endif; ?>
                </div>
        </div>
        </article>

        <footer class="bg-light text-center py-3 mt-5">
            <p class="mb-0">© 2024 Hotel da Serra. Todos os direitos reservados.</p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>