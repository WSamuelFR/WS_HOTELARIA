<?php
session_start();

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
    $reserva_id = $_POST['reserva_id'] ?? null;
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
    if (!$reserva_id || !$quarto_number || !$data_checkin || !$data_checkout || !$situacao || !$usuario_responsavel) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios!'); window.history.back();</script>";
        exit();
    }

    // Preparar consulta SQL para atualizar os dados
    $sql = "UPDATE reserva_quarto SET  
                hospede_one = ?, 
                hospede_two = ?, 
                hospede_three = ?, 
                hospede_four = ?, 
                quarto_number = ?, 
                data_checkin = ?, 
                data_checkout = ?, 
                total = ?, 
                observacoes = ?, 
                situacao = ?, 
                usuario_responsavel = ? 
            WHERE reserva_id = ?";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Erro na preparação da consulta: " . $conn->error . "'); window.history.back();</script>";
        exit();
    }

    // Vincular parâmetros
    $stmt->bind_param(
        "sssssssssssi",
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
        $usuario_responsavel,
        $reserva_id
    );

    // Executar a consulta
    if ($stmt->execute()) {
        echo "<script>alert('Dados da reserva atualizados com sucesso!'); window.location.href = 'atualize_reserva.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar os dados da reserva: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acesso inválido!'); window.location.href = 'lista_reservas.php';</script>";
    exit();
}
