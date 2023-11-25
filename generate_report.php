<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('tcpdf/tcpdf.php');

function generatePDFReport($data) {
    // Set absolute path for the generated PDF
    $pdfPath = __DIR__ . '/generated_reports/inventory_report.pdf';

    // Create new PDF document
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Inventory Report');
    $pdf->SetSubject('Inventory Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add content to the PDF
    $html = '<h1>Inventory Report</h1>';

    // Assuming $data is an array containing your inventory data
    foreach ($data as $row) {
        $html .= '<p>Product: ' . $row['ProductName'] . ', Stock Level: ' . $row['StockLevel'] . '</p>';
    }

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Save the PDF file
    if ($pdf->Output($pdfPath, 'F')) {
        echo 'PDF generated successfully. Path: ' . $pdfPath;
    } else {
        echo 'Error generating PDF: ' . $pdf->getError();
    }
}

// Check if the "generated_reports/" directory exists
if (!is_dir(__DIR__ . '/generated_reports/')) {
    echo 'Error: The "generated_reports/" directory does not exist.';
} else {
    // Fetch data from the database
    $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

    $sql = "SELECT * FROM Products";
    $result = mysqli_query($con, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($con);

    // Generate the PDF report
    generatePDFReport($data);
}
?>
