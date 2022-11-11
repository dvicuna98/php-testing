<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//
//$fileContent = file_get_contents('jsonfiles/anualTable2DDMBA.json');
//$data = json_decode($fileContent,true);


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('inicial');
$objWorkSheet = $spreadsheet->createSheet(1);
$objWorkSheet->setTitle("temp");
$objWorkSheet2 = $spreadsheet->createSheet(2);
$objWorkSheet2->setTitle("temp2");
$objWorkSheet3 = $spreadsheet->createSheet(1);
$objWorkSheet3->setTitle("temp3");
$objWorkSheet4 = $spreadsheet->createSheet();
$objWorkSheet4->setTitle("temp4");


$writer = new Xlsx($spreadsheet);
$writer->save('excel_name.xlsx');







?>