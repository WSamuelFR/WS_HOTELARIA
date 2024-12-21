<?php

// Incluir conexão com o banco de dados
include('../ConnectSQL/ConnectSqli.php');
$conn = Connect();

// Checar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário com fallback para valores padrão
    $hospede_titular_cpf = $_POST['hospede_cpf'] ?? null;
    $empresa_titular_cnpj = $_POST['empresa_cnpj'] ?? null;
    $hospede_one = $_POST['hospede_one'] ?? null;
    $hospede_two = $_POST['hospede_two'] ?? null;
    $hospede_three = $_POST['hospede_three'] ?? null;
    $hospede_four = $_POST['hospede_four'] ?? null;
    $quarto_number = $_POST['quarto_number'] ?? null;
    $data_checkin = $_POST['data_checkin'] ?? null;
    $data_checkout = $_POST['data_checkout'] ?? null;
    $total = $_POST['total'] ?? 0.0;
    $observacoes = $_POST['observacoes'] ?? null;
    $situacao = $_POST['situacao'] ?? 'pausada';
    $usuario_responsavel = $_POST['usuario_responsavel'] ?? 'Desconhecido';

    // Validar campos obrigatórios
    if (!$quarto_number || !$data_checkin || !$data_checkout || !$situacao || !$usuario_responsavel) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios!'); window.history.back();</script>";
        exit();
    }

    // Preparar consulta SQL para inserção
    $sql = "INSERT INTO reserva_quarto 
            (hospede_titular_cpf, empresa_titular_cnpj, hospede_one, hospede_two, hospede_three, hospede_four, quarto_number, data_checkin, data_checkout, total, observacoes, situacao, usuario_responsavel) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Erro na preparação da consulta: " . $conn->error . "'); window.history.back();</script>";
        exit();
    }

    // Vincular parâmetros
    $stmt->bind_param(
        "ssssssissdsss",
        $hospede_titular_cpf,
        $empresa_titular_cnpj,
        $hospede_one,
        $hospede_two,
        $hospede_three,
        $hospede_four,
        $quarto_number,
        $data_checkin,
        $data_checkout,
        $total,
        $observacoes,
        $situacao,
        $usuario_responsavel
    );

    // Executar a consulta
    if ($stmt->execute()) {
        echo "<script>alert('Reserva cadastrada com sucesso!'); window.location.href = '../menu/reserva.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar reserva: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acesso inválido!'); window.location.href = '../menu/reserva.php';</script>";
    exit();
}
