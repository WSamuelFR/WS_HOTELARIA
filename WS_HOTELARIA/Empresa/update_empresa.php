<?php
// Iniciar a sessão
session_start();

// Configuração do banco de dados
require('../ConnectSQL/ConnectSqli.php');

// Criando a conexão
$conn = Connect();

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura os dados do formulário
$cnpj = $_POST['cnpj'];
$company_name = $_POST['company_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$founding_date = $_POST['founding_date'];
$sector = $_POST['sector'];

// Prepare a consulta para atualizar os dados
$sql = "UPDATE empresa SET company_name = ?, phone = ?, email = ?, founding_date = ?, sector = ? WHERE cnpj = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $company_name, $phone, $email, $founding_date, $sector, $cnpj);

    // Executar a consulta
    if ($stmt->execute()) {
        $_SESSION['message'] = "Dados da empresa atualizados com sucesso!";
    } else {
        $_SESSION['message'] = "Erro ao atualizar os dados da empresa: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Erro ao preparar a consulta: " . $conn->error;
}

$conn->close();

// Redirecionar para a página de edição da empresa ou outra página de sua escolha
header("Location: atualize_empresa.php?cnpj=" . $cnpj);
exit();
?>
