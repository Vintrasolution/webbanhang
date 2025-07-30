<?php
// Include PHPExcel classes
require_once 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';

//$inputFileName = "*.xlsx";

foreach (glob("../../../../uploaderp/*.xlsx") as $inputFileName) {
            echo "$inputFileName size " . filesize($inputFileName) . "\n";
            }


// Load the input file
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

// Get the first worksheet
$worksheet = $objPHPExcel->getActiveSheet();

// Create an array to store the CSV data
$csvData = array();

// Loop through each row of the worksheet
foreach ($worksheet->getRowIterator() as $row) {
    $rowData = array();

    // Loop through each cell in the row
    foreach ($row->getCellIterator() as $cell) {
        // Get the cell value
        $cellValue = $cell->getValue();

        // Check if the cell is part of a merged cell
        $isMerged = false;
        foreach ($worksheet->getMergeCells() as $mergedCell) {
            if ($cell->isInRange($mergedCell)) {
                $isMerged = true;
                break;
            }
        }

        // If the cell is part of a merged cell, use the value of the first cell in the merged range
        if ($isMerged) {
            $cellValue = $worksheet->rangeToArray($mergedCell)[0][0];
        }

        // Add the cell value to the row data
        $rowData[] = $cellValue;
    }

    // Add the row data to the CSV data array
    $csvData[] = $rowData;
}

// Set the HTTP headers to download the CSV file
//header('Content-Encoding: UTF-8');
//header('Content-Type: text/csv; charset=UTF-8');
//header('Content-Disposition: attachment; filename="output.csv"');

// Đường dẫn tới thư mục lưu file trên server
//$savePath = "";

// Tạo tên file có định dạng theo ngày và giờ hiện tại
//$filename = date("Ymd_His") . ".csv";

// Mở file để ghi nội dung
//$file = fopen($savePath . $filename, "w");

// Ghi nội dung vào file
//fwrite($file, $outputBuffer);

// Write the CSV data to the output buffer
//$outputBuffer = fopen('php://output', 'w');
$outputBuffer = fopen('done/output.csv', 'w');
foreach ($csvData as $rowData) {
    fputcsv($outputBuffer, $rowData);
    //fwrite($file, $rowData);
}


// Đóng file sau khi ghi xong
//fclose($file);
//exit();
// Close the output buffer
fclose($outputBuffer);
unlink('../../../../uploaderp/thuoc_farm.xlsx');
exit();

?>
