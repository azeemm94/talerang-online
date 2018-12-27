<?php session_start();
    if(!isset($_SESSION['adminuser'])) { header('location:adminlogin.php'); exit; }
    date_default_timezone_set('Asia/Kolkata');
    require_once "vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
    $ea = new PHPExcel(); 
    ob_start();
    $ea->getProperties()
    ->setCreator('Azeem Merchant')
    ->setLastModifiedBy('Azeem Merchant')
    ->setTitle('Talerang Express Registerations');
    
  $ews = $ea->getSheet(0);
  $ews->setTitle('Registrations');

  $titles = array("ID", "First Name", "Last Name", "Email", "Country", "Phone No", "College", "About Us", "Registration Time", "Active", "Intro", "Account No");
  for($i=0,$col='A'; $i<count($titles); $i++,$col++)
    $ews->setCellValue($col.'1', $titles[$i]);

  $rowCount = 3; 
  
  require 'connectsql.php';
  $sql = "SELECT * FROM `register` ORDER BY id DESC LIMIT 10000";  
  $result = mysqli_query($DBcon, $sql);
      
   while($row = mysqli_fetch_assoc($result))  
   {  
        if($row["college"]=='SNDT University') continue;
        $ews->setCellValue('A'.$rowCount,$row["id"]);
        $ews->setCellValue('B'.$rowCount,$row["firstname"]);
        $ews->setCellValue('C'.$rowCount,$row["lastname"]);
        $ews->setCellValue('D'.$rowCount,$row["email"]);
        $ews->setCellValue('E'.$rowCount,$row["country"]);
        $ews->setCellValueExplicit('F'.$rowCount,$row["phoneno"],PHPExcel_Cell_DataType::TYPE_STRING);
        $ews->setCellValue('G'.$rowCount,$row["college"]);
        $ews->setCellValue('H'.$rowCount,$row["aboutus"]);
        $ews->setCellValue('I'.$rowCount,$row["regtime"]);
        $ews->setCellValue('J'.$rowCount,$row["active"]);
        $ews->setCellValue('K'.$rowCount,$row["intro"]);
        $ews->setCellValue('L'.$rowCount,$row["accountno"]);
        $rowCount++;
   } 

   $ews->setCellValue('A2',"Count : ".($rowCount-3));
    $column ='F1:F'.$rowCount;
    $style = array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
        );
    $ews->getStyle($column)->applyFromArray($style);

   //Header stlying
    $header = 'A1:I1';
    $style = array(
        'font' => array('bold' => true,),
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
        );
    $ews->getStyle($header)->applyFromArray($style);
    
    //Column Width
   for ($col = ord('A'); $col <= ord('L'); $col++)
    {
        $ews->getColumnDimension(chr($col))->setAutoSize(true);
    }
    
    //XLSX Header and download file
    $filename=date('dmY')."_Talerang Express Registerations.xlsx";
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    $writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');
    ob_end_clean();
    $writer->save('php://output');
   ?>