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

// Captura o CNPJ da empresa a partir da URL
$cnpj = isset($_GET['cnpj']) ? $_GET['cnpj'] : '';

if ($cnpj) {
    // Query para buscar a empresa pelo CNPJ
    $sql = "SELECT * FROM empresa WHERE cnpj = ?";
    $stmt = $conn->prepare($sql);

    // Verifique se a preparação da consulta falhou
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    // Vincular os parâmetros
    $stmt->bind_param("s", $cnpj);
    $stmt->execute();
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();
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
    <title>Editar Empresa</title>
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
                <form action="imprimir_empresa.php" method="GET" target="_blank">
                    <input type="hidden" name="buscacnpj" value="<?php echo htmlspecialchars($empresa['cnpj']); ?>">
                    <button id="menuButton" class="nav-link btn btn-light border" type="submit">Imprimir Dados da Empresa</button>
                </form>
                <a href="../menu/consulta.php" class="nav-link btn btn-light border">Voltar</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <article>
            <div class="tab-content">
                <h1 class="text-center mb-4">Editar Empresa</h1>

                <?php if (isset($empresa)): ?>
                    <form action="update_empresa.php" method="POST">
                        <fieldset class="border p-3 mb-4">
                            <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo htmlspecialchars($empresa['cnpj']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="company_name">Nome da Empresa</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo htmlspecialchars($empresa['company_name']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($empresa['email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Telefone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($empresa['phone']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="founding_date">Data de Fundação</label>
                                <input type="date" class="form-control" id="founding_date" name="founding_date" value="<?php echo htmlspecialchars($empresa['founding_date']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="sector">Setor</label>
                                <input type="text" class="form-control" id="sector" name="sector" value="<?php echo htmlspecialchars($empresa['sector']); ?>" required>
                            </div><br><br>

                            <center>
                                <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Tem certeza que deseja salvar?');">Salvar alterações</button>
                            </center>

                        </fieldset>
                    </form>

                <?php else: ?>
                    <p class="text-center">Empresa não encontrada.</p>
                <?php endif; ?>
            </div>
        </article>

    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© 2024 Hotel da Serra. Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>