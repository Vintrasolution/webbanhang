<?php

	use Box\Spout\Reader\Common\Creator\ReaderFactory;
	use Box\Spout\Common\Type;

	// Read the XLSX file using Spout
	$reader = ReaderFactory::createFromType(Type::XLSX);
	$reader->open('upload/*.xlsx');

	// Create a CSV file to export the data
	$csv_file = fopen('upload/*.csv', 'w');

	// Iterate over each row and export the data to CSV
	foreach ($reader->getSheetIterator() as $sheet) {
	    foreach ($sheet->getRowIterator() as $row) {
	        // Extract the merged cells into separate cells
	        $cells = $row->getCells();
	        foreach ($cells as $key => $cell) {
	            if ($cell->isMerged()) {
	                $merged_cells = $cell->getMergedCells();
	                foreach ($merged_cells as $merged_cell) {
	                    $new_cell = clone $cell;
	                    $new_cell->setValue($sheet->getCellAt($merged_cell)->getValue());
	                    $cells[$merged_cell] = $new_cell;
	                }
	            }
	        }

	        // Export the data to CSV
	        $data = [];
	        foreach ($cells as $cell) {
	            $data[] = $cell->getValue();
	        }
	        fputcsv($csv_file, $data);
	    }
	}

	// Close the CSV file and the XLSX reader
	fclose($csv_file);
	$reader->close();
?>