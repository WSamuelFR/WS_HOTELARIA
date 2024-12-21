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
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$rg = isset($_POST['rg']) ? $_POST['rg'] : '';
$birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$ethnicity = isset($_POST['ethnicity']) ? $_POST['ethnicity'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$birth_country = isset($_POST['birth_country']) ? $_POST['birth_country'] : '';
$current_country = isset($_POST['current_country']) ? $_POST['current_country'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$neighborhood = isset($_POST['neighborhood']) ? $_POST['neighborhood'] : '';
$street = isset($_POST['street']) ? $_POST['street'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$cep = isset($_POST['cep']) ? $_POST['cep'] : '';

// Validação básica de preenchimento de campos
if (empty($first_name) || empty($last_name) || empty($cpf) || empty($email)) {
    die("Por favor, preencha todos os campos obrigatórios.");
}

// Prepara a query para verificar se o CPF já existe
$sql = "SELECT cpf FROM hospedes WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Erro! Hospede já cadastrado com este CPF.'); window.location.href = '../menu/clientes.php';</script>";
    $stmt->close();
    $conn->close();
    exit;
}

// Prepara a query de inserção
$sql = "INSERT INTO hospedes 
        (first_name, last_name, cpf, rg, birth_date, gender, ethnicity, email, phone, birth_country, current_country, state, city, neighborhood, street, address, cep)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssssssss",
    $first_name,
    $last_name,
    $cpf,
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
    $cep
);

// Executa a query e verifica o sucesso da inserção
if ($stmt->execute()) {
    echo "<script>alert('Hospede cadastrado com sucesso!'); window.location.href = '../menu/clientes.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar Hospede: " . $stmt->error . "'); window.location.href = '../menu/clientes.php';</script>";
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>

<!-- Botão para retornar ao formulário de cadastro -->
<div class="text-center mt-4">
    <a href="formulario_cadastro.php" class="btn btn-primary">Cadastrar Novo Hóspede</a>
</div>