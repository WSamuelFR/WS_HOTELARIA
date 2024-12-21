<?php
// Conexão com o banco de dados
include('../ConnectSQL/ConnectSqli.php');

// Criar conexão
$conn = Connect();

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura o CNPJ enviado pelo formulário
$pdfempresa = isset($_GET['buscacnpj']) ? $_GET['buscacnpj'] : null;

if ($pdfempresa) {
    // Função para gerar PDF
    require_once('../Utilitarios/tcpdf/tcpdf.php'); // Certifique-se de que o caminho para TCPDF esteja correto

    // Query para buscar os dados da empresa
    $sql = "SELECT * FROM empresa WHERE cnpj = ?";
    $stmt = $conn->prepare($sql);

    // Verifique se a preparação da consulta falhou
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $pdfempresa);
    $stmt->execute();
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();

    if ($empresa) {
        // Criação do objeto PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Seu Nome ou Hotel');
        $pdf->SetTitle('Dados da Empresa');
        $pdf->SetSubject('Informações da Empresa');
        $pdf->SetKeywords('TCPDF, PDF, empresa, hotel');

        $pdf->AddPage();

        // Definir o cabeçalho
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Dados da Empresa', 0, 1, 'C');
        $pdf->Ln(10);

        // Exibir dados da empresa com tradução dos nomes das colunas
        $translatedKeys = [
            'company_name' => 'Nome da Empresa',
            'cnpj' => 'CNPJ',
            'email' => 'Email',
            'phone' => 'Telefone',
            'founding_date' => 'Data de Fundação',
            'sector' => 'Setor'
        ];

        // Definir estilos para os dados
        $pdf->SetFont('helvetica', '', 12);
        foreach ($translatedKeys as $key => $label) {
            if (isset($empresa[$key])) {
                $pdf->Cell(0, 10, $label . ': ' . $empresa[$key], 0, 1);
            }
        }

        // Saída do PDF
        $pdf->Output('Dados_Empresa_' . $empresa['cnpj'] . '.pdf', 'D');
    } else {
        echo "Empresa não encontrada.";
    }
} else {
    echo "CNPJ não fornecido.";
}
