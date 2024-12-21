<?php
// Conexão com o banco de dados
include('../ConnectSQL/ConnectSqli.php');

// Criar conexão
$conn = Connect();

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura o ID da reserva enviado pelo link
$reserva_id = isset($_GET['reserva_id']) ? intval($_GET['reserva_id']) : null;

if ($reserva_id) {
    // Função para gerar PDF
    require_once('../Utilitarios/tcpdf/tcpdf.php'); // Certifique-se de que o caminho para TCPDF esteja correto

    // Query para buscar os dados da reserva, hóspede ou empresa
    $sql = "
        SELECT r.*, 
               h.first_name, h.last_name, h.cpf, 
               e.company_name, e.cnpj
        FROM reserva_quarto r
        LEFT JOIN hospedes h ON r.hospede_titular_cpf = h.cpf
        LEFT JOIN empresa e ON r.empresa_titular_cnpj = e.cnpj
        WHERE r.reserva_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $reserva = $result->fetch_assoc();

    if ($reserva) {
        // Criação do objeto PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hotel Da Serra');
        $pdf->SetTitle('Nota Fiscal da Reserva');
        $pdf->SetSubject('Informações da Reserva');
        $pdf->SetKeywords('TCPDF, PDF, reserva, hotel, nota fiscal');

        // Configurações do PDF
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // Estilo da Nota Fiscal
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'HOTEL DA SERRA LTDA', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'CNPJ: 12.345.678/0001-99', 0, 1, 'C');
        $pdf->Cell(0, 6, 'Endereço: Rua Exemplo, 123 - Centro, Cidade - Estado', 0, 1, 'C');
        $pdf->Cell(0, 6, 'Telefone: (99) 99999-9999 | E-mail: contato@hotelexemplo.com.br', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'NOTA FISCAL DE SERVIÇO', 0, 1, 'C');
        $pdf->Ln(10);

        // Informações do Cliente
        $pdf->SetFont('helvetica', '', 12);
        if ($reserva['first_name']) {
            $pdf->Cell(0, 6, 'Cliente: ' . $reserva['first_name'] . ' ' . $reserva['last_name'], 0, 1);
            $pdf->Cell(0, 6, 'CPF: ' . $reserva['cpf'], 0, 1);
        } elseif ($reserva['company_name']) {
            $pdf->Cell(0, 6, 'Empresa: ' . $reserva['company_name'], 0, 1);
            $pdf->Cell(0, 6, 'CNPJ: ' . $reserva['cnpj'], 0, 1);
        }
        $pdf->Ln(5);

        // Detalhes da Reserva
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, 'Detalhes da Reserva', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Número do Quarto: ' . $reserva['quarto_number'], 0, 1);
        $pdf->Cell(0, 6, 'Data de Check-in: ' . $reserva['data_checkin'], 0, 1);
        $pdf->Cell(0, 6, 'Data de Check-out: ' . $reserva['data_checkout'], 0, 1);
        $pdf->Cell(0, 6, 'Situação: ' . ucfirst($reserva['situacao']), 0, 1);
        $pdf->Ln(5);

        // Valor Total
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, 'Total: R$ ' . number_format($reserva['total'], 2, ',', '.'), 0, 1, 'L');
        $pdf->Ln(5);

        // Observações
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, 'Observações:', 0, 1, 'L');
        $pdf->MultiCell(0, 6, $reserva['observacoes'] ?: 'Nenhuma observação.', 0, 'L');
        $pdf->Ln(10);

        // Rodapé
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 6, 'Documento gerado automaticamente. Não é necessário assinatura.', 0, 1, 'C');

        // Saída do PDF
        $pdf->Output('Nota_Fiscal_Reserva_' . $reserva['reserva_id'] . '.pdf', 'D');
    } else {
        echo "Reserva não encontrada.";
    }

    $stmt->close();
} else {
    echo "ID da reserva não fornecido.";
}

$conn->close();
