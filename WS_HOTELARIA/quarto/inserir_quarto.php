<?php
// Incluir conexão com o banco de dados
include('../ConnectSQL/ConnectSqli.php');
$conn = Connect();

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificando se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo os dados do formulário
    $room_number = $_POST['room_number'];
    $bed_quantity = $_POST['bed_quantity'];
    $room_type = $_POST['room_type'];

    try {
        // Verificar se o número do quarto já existe
        $sql_check = "SELECT number_room FROM quarto WHERE number_room = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $room_number);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Quarto já cadastrado
            echo "<script>alert('Erro! Quarto já cadastrado.'); window.location.href = '../menu/reserva.php';</script>";
        } else {
            // Inserindo o novo quarto
            $sql_insert = "INSERT INTO quarto (number_room, room_type, bed_quantity) 
                           VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iss", $room_number, $room_type, $bed_quantity);

            if ($stmt_insert->execute()) {
                echo "<script>alert('Quarto cadastrado com sucesso!'); window.location.href = '../menu/reserva.php';</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar o quarto: " . $stmt_insert->error . "'); window.location.href = '../menu/reserva.php';</script>";
            }

            // Fechando a declaração de inserção
            $stmt_insert->close();
        }

        // Fechando a declaração de verificação
        $stmt_check->close();
    } catch (Exception $e) {
        // Tratando erros inesperados
        echo "<script>alert('Erro inesperado: " . $e->getMessage() . "'); window.location.href = '../menu/reserva.php';</script>";
    }

    // Fechando a conexão
    $conn->close();
}
