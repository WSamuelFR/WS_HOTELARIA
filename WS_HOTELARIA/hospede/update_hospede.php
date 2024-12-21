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

// Captura os dados do formulário
$cpf = $_POST['cpf']; // O CPF é utilizado como identificador único
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$rg = $_POST['rg'];
$birth_date = $_POST['birth_date'];
$gender = $_POST['gender'];
$ethnicity = $_POST['ethnicity'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$birth_country = $_POST['birth_country'];
$current_country = $_POST['current_country'];
$state = $_POST['state'];
$city = $_POST['city'];
$neighborhood = $_POST['neighborhood'];
$street = $_POST['street'];
$address = $_POST['address'];
$cep = $_POST['cep'];

// Prepare a consulta para atualizar os dados
$sql = "UPDATE hospedes SET first_name = ?, last_name = ?, rg = ?, birth_date = ?, gender = ?, 
        ethnicity = ?, email = ?, phone = ?, birth_country = ?, current_country = ?, 
        state = ?, city = ?, neighborhood = ?, street = ?, address = ?, cep = ? 
        WHERE cpf = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param(
        "sssssssssssssssss",
        $first_name,
        $last_name,
        $rg,
        $birth_date,
        $gender,
        $ethnicity,
        $email,
        $phone,
        $birth_country,
        $current_country,
        $state,
        $city,
        $neighborhood,
        $street,
        $address,
        $cep,
        $cpf
    );

    // Verifica se a execução foi bem-sucedida
    if ($stmt->execute()) {
        $_SESSION['message'] = "Dados do hóspede atualizados com sucesso!";
    } else {
        $_SESSION['message'] = "Erro ao atualizar os dados do hóspede: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Erro ao preparar a consulta: " . $conn->error;
}

$conn->close();

// Redirecionar para a página de edição do hóspede com a mensagem
header("Location: atualize_hospede.php?cpf=" . urlencode($cpf));
exit();
