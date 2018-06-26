<?php
  session_start();
  include 'pdf2excel.php';

  $fileNum = $_SESSION['indexFile'];
  $filePath = $_SESSION['filePath'];


  //For testing....
  /*
  $filePath[0] = "uploads/sample0.pdf";
  $filePath[1] = "uploads/sample1.pdf";
  $filePath[2] = "uploads/sample2.pdf";
  // $filePath[3] = "uploads/sample3.pdf";
  // $filePath[4] = "uploads/sample4.pdf";
  // $filePath[5] = "uploads/sample5.pdf";
  */
  $colNum = 14;

  $colName[0] = "PO Number";
  $colName[1] = "PO Date";
  $colName[2] = "Contract No";
  $colName[3] = "Payment Terms";
  $colName[4] = "Incoterms";
  $colName[5] = "Project";
  $colName[6] = "Cost Center";
  $colName[7] = "Tracking No";
  $colName[8] = "Project Manager";
  $colName[9] = "Contact Person";
  $colName[10] = "Contact No";
  $colName[11] = "Delivery Date";
  $colName[12] = "Subtotal";
  $colName[13] = "Total Amount";

  //$fileNum = 3;


  //check whether file is selected
  $dunProceed2 = false;
  if($fileNum == 0){
    $dunProceed2 = true;
    $reason2 = "---------------Please upload at least one file from your directory.---------------";
  }

  if(mainConvert($filePath, $colNum, $colName) && $dunProceed2 == false){
    $result = "-- Excel File is generated successfully!--";

  }else {
    $result = "----Sorry, Excel File fail to generate!----";
  }

  $_SESSION['result'] = $result;
  $_SESSION['reason2'] = $reason2;
  $_SESSION['dP2'] = $dunProceed2;
  echo $result;

  //delete uploaded files
  for($i=0;$i<$fileNum;$i++){
    unlink($filePath[$i]);
  }

  unset ($_SESSION['filePath']);
  unset ($_SESSION['fileName']);
  unset ($_SESSION['colNum']);
  unset ($_SESSION['colName']);
  unset ($_SESSION['output']);
  unset ($_SESSION['arraySize']);
  unset($_SESSION['indexFile']);

  header('Location: index.php');
?>
