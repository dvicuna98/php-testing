<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

$PHPWord = new PhpWord();


try {
    if(file_exists('TemplatesDocx/TestTemplate.docx')){
        $document = new TemplateProcessor('TemplatesDocx/TestTemplate.docx');
        $document->setValue('FORM_CODE', 'Example code here');
        $document->setValue('ACADEMIC_PERIOD', 'Example academic period');

        // tables

        //-------------------deprecated way that works------------
//        $document_with_table = new PhpWord();
//        $section = $document_with_table->addSection();
//        $table = $section->addTable();
//        for ($r = 1; $r <= 3; $r++) {
//            $table->addRow();
//            for ($c = 1; $c <= 3; $c++) {
//                $table->addCell()->addText("Row {$r}, Cell {$c}");
//            }
//        }
//        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document_with_table);
//        $fullxml = $objWriter->getWriterPart('Document')->write();
//        $tablexml = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);
//
//        $document->setValue('TEST_TABLE',  '</w:t></w:r></w:p>'.$tablexml.'<w:p><w:r><w:t>');
//

        //---------------documentation way -----------

        /*Styles*/
        $TableStyle = ['borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50];
        $TableCellStyle = ['valign' => 'center'];
        $fancyTableFontStyle = ['bold' => true];

        /*Tables*/
        $table = new Table($TableStyle);
        $table->addRow();
        $table->addCell(style: $TableCellStyle)->addText('Cell A1',$fancyTableFontStyle);
        $table->addCell(style: $TableCellStyle)->addText('Cell A2',$fancyTableFontStyle);
        $table->addCell(style: $TableCellStyle)->addText('Cell A3',$fancyTableFontStyle);
        $table->addRow();
        $table->addCell(style: $TableCellStyle)->addText('Cell B1');
        $table->addCell(style: $TableCellStyle)->addText('Cell B2');
        $table->addCell(style: $TableCellStyle)->addText('Cell B3');

        $document->setComplexBlock('TEST_TABLE', $table);

        $table2 = new Table($TableStyle);
        $table2->addRow();
        $table2->addCell(300,$TableCellStyle)->addText('Cell A1',$fancyTableFontStyle);
        $table2->addCell(300,$TableCellStyle)->addText('Cell A2',$fancyTableFontStyle);
        $table2->addCell(300,$TableCellStyle)->addText('Cell A3',$fancyTableFontStyle);
        $table2->addCell(300,$TableCellStyle)->addText('Cell A4',$fancyTableFontStyle);
        $table2->addCell(300,$TableCellStyle)->addText('Cell A5',$fancyTableFontStyle);
        $table2->addRow();
        $table2->addCell(300,$TableCellStyle)->addText('Cell B1');
        $table2->addCell(300,$TableCellStyle)->addText('Cell B2');
        $table2->addCell(300,$TableCellStyle)->addText('Cell B3');
        $table2->addCell(300,$TableCellStyle)->addText('Cell B4');
        $table2->addCell(300,$TableCellStyle)->addText('Cell B5');

        $document->setComplexBlock('TEST_TABLE_2', $table2);

        $table3 = new Table($TableStyle);
        $table3->addRow(3000);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A1',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A2',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A3',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A4',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A5',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A6',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A7',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A8',$fancyTableFontStyle);
        $table3->addCell(style: $TableCellStyle)->addText('Cell A9',$fancyTableFontStyle);
        $table3->addRow();
        $table3->addCell(style: $TableCellStyle)->addText('Cell B1');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B2');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B3');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B4');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B5');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B6');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B7');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B8');
        $table3->addCell(style: $TableCellStyle)->addText('Cell B9');

        $document->setComplexBlock('TEST_TABLE_3', $table3);

        $document->saveAs('word.docx');
    }else{
        echo 'NO existo';
    }
} catch (\PhpOffice\PhpWord\Exception\Exception $e) {
    echo $e->getMessage();
}
