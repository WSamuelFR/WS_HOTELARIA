<?php

session_start();

// Configuração do banco de dados
require('../ConnectSQL/ConnectSqli.php');

// Criando a conexão
$conn = Connect();

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura o CPF do hóspede a partir da URL
$cpf = intval($_GET['cpf']) ? $_GET['cpf'] : '';

if ($cpf) {
    // Query para buscar o hóspede pelo CPF
    $sql = "SELECT * FROM hospedes WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    $hospede = $result->fetch_assoc();
}

// Verificar e exibir mensagens da sessão
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['message'];
    echo "</div>";
    // Limpar a mensagem após exibi-la
    unset($_SESSION['message']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hóspede</title>
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
            font-size: 1.2rem;
            /* Ajuste o tamanho dos ícones */
        }
    </style>
</head>

<body>

    <header>
        <div class="container text-center">
            <h1>HOTEL DA SERRA</h1>
            <h2>Editar Empresa</h2>
            <nav class="nav justify-content-center mt-3">
                <!-- Botões para imprimir e voltar -->
                <form action="imprimir_hospede.php" method="GET" target="_blank">
                    <input type="hidden" name="buscacpf" value="<?php echo $hospede['cpf']; ?>">
                    <button type="submit" class="nav-link btn btn-light border">Imprimir Dados do Hóspede</button>
                </form>
                <a href="../menu/consulta.php" class="nav-link btn btn-light border">Voltar</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <article>
            <div class="tab-content">
                <h1 class="text-center mb-4">Editar Empresa</h1>

                <?php if ($hospede): ?>
                    <form action="update_hospede.php" method="POST">
                        <!-- Informações Pessoais -->
                        <fieldset class="border p-3 mb-4">
                            <legend class="w-auto px-2">Informações Pessoais</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $hospede['first_name']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $hospede['last_name']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $hospede['cpf']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rg" class="form-label">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" value="<?php echo $hospede['rg']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo $hospede['birth_date']; ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="gender" class="form-label">Gênero</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="masculino" <?php echo ($hospede['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="feminino" <?php echo ($hospede['gender'] == 'feminino') ? 'selected' : ''; ?>>Feminino</option>
                                        <option value="outro" <?php echo ($hospede['gender'] == 'outro') ? 'selected' : ''; ?>>Outro</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="ethnicity" class="form-label">Etnia</label>
                                    <select class="form-select" id="ethnicity" name="ethnicity" required>
                                        <option value="branco" <?php echo ($hospede['ethnicity'] == 'branco') ? 'selected' : ''; ?>>Branco</option>
                                        <option value="negro" <?php echo ($hospede['ethnicity'] == 'negro') ? 'selected' : ''; ?>>Negro</option>
                                        <option value="pardo" <?php echo ($hospede['ethnicity'] == 'pardo') ? 'selected' : ''; ?>>Pardo</option>
                                        <option value="indigena" <?php echo ($hospede['ethnicity'] == 'indigena') ? 'selected' : ''; ?>>Indígena</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $hospede['email']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $hospede['phone']; ?>" required>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Endereço -->
                        <fieldset class="border p-3 mb-4">
                            <legend class="w-auto px-2">Endereço</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_country" class="form-label">País de Nascimento</label>
                                    <input type="text" class="form-control" id="birth_country" name="birth_country" value="<?php echo $hospede['birth_country']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="current_country" class="form-label">País Atual</label>
                                    <input type="text" class="form-control" id="current_country" name="current_country" value="<?php echo $hospede['current_country']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="state" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $hospede['state']; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo $hospede['city']; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="neighborhood" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?php echo $hospede['neighborhood']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="street" class="form-label">Rua</label>
                                    <input type="text" class="form-control" id="street" name="street" value="<?php echo $hospede['street']; ?>" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="address" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $hospede['address']; ?>" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $hospede['cep']; ?>" required>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Botão de Envio -->
                        <center>
                            <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Salvar alterações</button>
                        </center>
                    </form>


                <?php else: ?>
                    <p class="text-center">Hóspede não encontrado.</p>
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