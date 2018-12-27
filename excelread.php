<!DOCTYPE html>
<html>
<head>
	<title>Excel Reader</title>
	<style type="text/css">
		table,tr,td,th{
			border: solid 1px black;
		}
	</style>
</head>
<body>
<?php 
require_once('../PHPExcelClasses/PHPExcel.php');
$tempfile=""; //insert filename
$excelReader = PHPExcel_IOFactory::createReaderForFile($tempfile);
$excelObj = $excelReader->load($tempfile);
$worksheet = $excelObj->getSheet(9);
$lastRow = $worksheet->getHighestRow();
$lastColumn = $worksheet->getHighestColumn();
$lastColumn++;

		/*echo "<table cellpadding="0">";
		for ($row = 1; $row <= $lastRow; $row++) {
			 echo "<tr><td>";
			 echo $row;
			 echo "</td><td>";
			 echo $worksheet->getCell('A'.$row)->getCalculatedValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('B'.$row)->getCalculatedValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('C'.$row)->getCalculatedValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('D'.$row)->getCalculatedValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('E'.$row)->getCalculatedValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('F'.$row)->getCalculatedValue();
			 echo "</td><tr>";
		}
		echo "</table>";*/	

		echo "<table cellspacing=\"0px\">";
		for ($row = 1; $row <= $lastRow; $row++) {
			echo "<tr><td>".$row."</td>";
			for($column = 'A'; $column != $lastColumn; $column++){
			 echo "<td>".$worksheet->getCell($column.$row)->getCalculatedValue()."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
?>
</body>
</html>