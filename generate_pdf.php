<?php
// Start output buffering to prevent premature output
ob_start();
session_start();

// Disable error reporting in output to prevent corrupting PDF
error_reporting(0);
ini_set('display_errors', 0);

// Check if ID and contact_info are set
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['contact_info']) || empty($_GET['contact_info'])) {
    exit("No ID or Contact Info provided.");
}

$id = $_GET['id'];
$contact_info = $_GET['contact_info'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "portfolio_form";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    exit("Connection failed.");
}

// Validate ID and Contact Info
$sql = "SELECT * FROM form_portfolio WHERE ID = ? AND contact_info = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $contact_info);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    exit("Invalid ID or Contact Info.");
}

$row = $result->fetch_assoc();

// Include TCPDF library
require_once __DIR__ . '/tcpdf/tcpdf.php';

// Create new PDF instance
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($row['Full_Name']);
$pdf->SetTitle('Portfolio - ' . $row['Full_Name']);
$pdf->SetMargins(15, 10, 15);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, "Portfolio of " . $row['Full_Name'], 0, 1, 'C');
$pdf->Ln(5);

// Image Handling
$imagePath = __DIR__ . "/" . trim($row['photo']);
if (!empty($row['photo']) && file_exists($imagePath)) {
    $pdf->Image($imagePath, 15, $pdf->GetY(), 50);
    $pdf->Ln(55);
} else {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "Image not available", 0, 1, 'C');
}

// Display User Information with Grey Headers
$pdf->SetFont('helvetica', '', 12);
$html = '
    <table>
        <tr><td style="background-color: #D3D3D3; font-weight: bold;">Personal Information</td></tr>
    </table>
    <p><strong>Full Name:</strong> ' . htmlspecialchars($row['Full_Name']) . '</p>
    <p><strong>Contact Info:</strong> ' . htmlspecialchars($row['contact_info']) . '</p>
    <p><strong>Biography:</strong> ' . nl2br(htmlspecialchars($row['biography'])) . '</p>

    <table>
        <tr><td style="background-color: #D3D3D3; font-weight: bold;">Skills</td></tr>
    </table>
    <p><strong>Soft Skills:</strong> ' . htmlspecialchars($row['soft_skills']) . '</p>
    <p><strong>Technical Skills:</strong> ' . htmlspecialchars($row['technical_skills']) . '</p>';

if (!empty($row['institute'])) {
    $html .= '
    <table>
        <tr><td style="background-color: #D3D3D3; font-weight: bold;">Academic Background</td></tr>
    </table>
    <p><strong>Institute:</strong> ' . htmlspecialchars($row['institute']) . '</p>
    <p><strong>Degree:</strong> ' . htmlspecialchars($row['degree']) . '</p>
    <p><strong>Year:</strong> ' . htmlspecialchars($row['year']) . '</p>
    <p><strong>Grade:</strong> ' . htmlspecialchars($row['grade']) . '</p>';
}

$html .= '
    <table>
        <tr><td style="background-color: #D3D3D3; font-weight: bold;">Work Experience</td></tr>
    </table>
    <p><strong>Company Name:</strong> ' . htmlspecialchars($row['company_name']) . '</p>
    <p><strong>Job Duration:</strong> ' . htmlspecialchars($row['job_duration']) . '</p>
    <p><strong>Job Responsibility:</strong> ' . nl2br(htmlspecialchars($row['job_responsibility'])) . '</p>';

if (!empty($row['previous_project']) || !empty($row['previous_publication'])) {
    $html .= '
    <table>
        <tr><td style="background-color: #D3D3D3; font-weight: bold;">Previous Projects & Publications</td></tr>
    </table>';
}

if (!empty($row['previous_project'])) {
    $html .= '<p><strong>Previous Project:</strong> ' . htmlspecialchars($row['previous_project']) . '</p>';
}

if (!empty($row['previous_publication'])) {
    $html .= '<p><strong>Previous Publication:</strong> ' . htmlspecialchars($row['previous_publication']) . '</p>';
}

// Write HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Set headers to force download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="portfolio_' . $id . '.pdf"');
header('Cache-Control: max-age=0');

// Output PDF
$pdf->Output('portfolio_' . $id . '.pdf', 'I');

$conn->close();
ob_end_flush();
?>
