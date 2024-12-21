<?php
// Configuração do banco de dados
require('../ConnectSQL/ConnectSqli.php');

// Criando a conexão
$conn = Connect();

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura os dados do formulário
$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$founding_date = isset($_POST['founding_date']) ? $_POST['founding_date'] : '';
$sector = isset($_POST['sector']) ? $_POST['sector'] : '';

// Validação básica de preenchimento de campos
if (empty($company_name) || empty($cnpj) || empty($email)) {
    die("Por favor, preencha todos os campos obrigatórios.");
}

// Prepara a query para verificar se o CNPJ já está cadastrado
$sql_check = "SELECT cnpj FROM empresa WHERE cnpj = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $cnpj);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// Verifica se o CNPJ já existe
if ($result_check->num_rows > 0) {
    echo "<script>alert('Erro! Empresa com este CNPJ já cadastrada.'); window.location.href = '../menu/clientes.php';</script>";
    $stmt_check->close();
    $conn->close();
    exit();
}

// Prepara a query de inserção usando Prepared Statements para maior segurança
$sql_insert = "INSERT INTO empresa 
                (company_name, cnpj, phone, email, founding_date, sector)
                VALUES (?, ?, ?, ?, ?, ?)";

$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param(
    "ssssss",
    $company_name,
    $cnpj,
    $phone,
    $email,
    $founding_date,
    $sector
);

// Executa a query de inserção e verifica o sucesso
if ($stmt_insert->execute()) {
    echo "<script>alert('Empresa cadastrada com sucesso!'); window.location.href = '../menu/clientes.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar empresa: " . $stmt_insert->error . "'); window.location.href = '../menu/clientes.php';</script>";
}

// Fecha a conexão com o banco de dados
$stmt_insert->close();
$conn->close();
?>

<!-- Botão para retornar ao formulário de cadastro -->
<div class="text-center mt-4">
    <a href="formulario_cadastro_empresa.php" class="btn btn-primary">Cadastrar Nova Empresa</a>
</div>