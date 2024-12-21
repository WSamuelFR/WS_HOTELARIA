<?php
// Conexão com o banco de dados
include('../ConnectSQL/ConnectSqli.php');

// Criar conexão
$conn = Connect();

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura o CPF enviado pelo formulário
$pdfhospede = isset($_GET['buscacpf']) ? $_GET['buscacpf'] : null;

if ($pdfhospede) {
    // Função para gerar PDF
    require_once('../Utilitarios/tcpdf/tcpdf.php'); // Certifique-se de que o caminho para TCPDF esteja correto

    // Query para buscar os dados do hóspede
    $sql = "SELECT * FROM hospedes WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pdfhospede);
    $stmt->execute();
    $result = $stmt->get_result();
    $hospede = $result->fetch_assoc();

    if ($hospede) {
        // Criação do objeto PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Seu Nome ou Hotel');
        $pdf->SetTitle('Dados do Hóspede');
        $pdf->SetSubject('Informações do Hóspede');
        $pdf->SetKeywords('TCPDF, PDF, hóspede, hotel');

        $pdf->AddPage();

        // Definir o cabeçalho
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Dados do Hóspede', 0, 1, 'C');
        $pdf->Ln(10);

        // Exibir dados do hóspede com tradução dos nomes das colunas
        $translatedKeys = [
            'first_name' => 'Nome',
            'last_name' => 'Sobrenome',
            'cpf' => 'CPF',
            'rg' => 'RG',
            'birth_date' => 'Data de Nascimento',
            'gender' => 'Gênero',
            'ethnicity' => 'Etnia',
            'email' => 'Email',
            'phone' => 'Telefone',
            'birth_country' => 'País de Nascimento',
            'current_country' => 'País Atual',
            'state' => 'Estado',
            'city' => 'Cidade',
            'neighborhood' => 'Bairro',
            'street' => 'Rua',
            'address' => 'Logadouro',
            'cep' => 'CEP'
        ];

        // Definir estilos para os dados
        $pdf->SetFont('helvetica', 'B', 12);
        foreach ($translatedKeys as $key => $label) {
            if (isset($hospede[$key])) {
                $pdf->Cell(0, 10, $label . ': ' . $hospede[$key], 0, 1);
            }
        }

        // Saída do PDF
        $pdf->Output('Dados_Hospede_' . $hospede['cpf'] . '.pdf', 'D');
    } else {
        echo "Hóspede não encontrado.";
    }
} else {
    echo "CPF não fornecido.";
}
