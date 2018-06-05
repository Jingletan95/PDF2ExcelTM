<?php
  session_start();
  include 'pdf2excel.php';

  //$filePath = $_SESSION['filePath'];
  //$colName = $_SESSION['colName'];
  //$colNum = $_SESSION['colNum'];

  //For testing....
  $filePath[0] = "uploads/sample0.pdf";
  $filePath[1] = "uploads/sample1.pdf";
  $filePath[2] = "uploads/sample2.pdf";
  $filePath[3] = "uploads/sample3.pdf";
  $filePath[4] = "uploads/sample4.pdf";
  $filePath[5] = "uploads/sample5.pdf";

  $colNum = 6;

  $colName[0] = "PO Number";
  $colName[1] = "PO Date";
  $colName[2] = "Contact Person";
  $colName[3] = "Contact No";
  $colName[4] = "Delivery Date";
  $colName[5] = "Total Amount";

  if(mainConvert($filePath, $colNum, $colName)){
    $result = "Excel File is generated successfully!";

  }else {
    $result = "Sorry, Excel File fail to generate!";
  }

  $_SESION['result'] = $result;
  echo $result;

  //header('Location: index.php');
?>
