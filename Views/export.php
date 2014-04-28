<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 28/4/14
 * Time: 11:05 AM
 * To change this template use File | Settings | File Templates.
 */

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$emp = new Emp($dbConn);
$result = $emp->viewEmpExcel();


$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Chetna Patil")
    ->setLastModifiedBy("Chetna Patil")
    ->setTitle("Employee Information")
    ->setSubject("Employee Information")
    ->setDescription("Employee Information")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Employee Information");

$objPHPExcel->setActiveSheetIndex(0);

$i = 1;
$charVal = 65;
foreach($result as $row)
{
    for($index = 0, $count = count($row) / 2; $index < $count; $index++)
    {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(strval(chr($charVal) . $i), $row[$index]);
        $charVal++;
    }
    $i++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file

$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
echo "Exported to export.xlsx";
?>