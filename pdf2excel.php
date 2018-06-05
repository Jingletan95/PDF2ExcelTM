<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

//function to get the final pos of the information
function getFinalPos($first, $txt){
  $final = $first;
  //echo $txt[$final + 1];

  while($txt[$final] !== "\n"){
    //echo $txt[$final];
    //echo "pos: ". $final." ".$txt[$final]."\n";

    $final = $final + 1;
  }
  return $final;
}

//function to obtain info from given position
function getInformationString($start, $txt){

  //echo "hello\t";
  $end = getFinalPos($start,$txt);

  $len = $end -$start + 1;
  return substr($txt, $start, $len );
}

//function to check whether a str is a date
function isDate($date){
  try{
    //initialise array
    for ($i = 0 ; $i <=2;$i++){
      $temp[$i] = "";
    }

    $temp= explode(".", $date);
    //echo "**";
    //echo $temp[0]."\t".$temp[1]."\t".$temp[2];
    //echo "**\n";
    if(is_numeric($temp[0]) && is_numeric($temp[1]) && is_numeric($temp[2])){

      //echo $temp[0]."\t".$temp[1]."\t".$temp[2];
      $temp[0] = (int)($temp[0]);
      $temp[1] = (int)($temp[1]);
      $temp[2] = (int)($temp[2]);

      if ($temp[0] >=1 && $temp[0] <=31){
        if($temp[1] >=1 && $temp[1] <=12){
          if($temp[2] >=2000 && $temp[2] <=9999){
            return true;
          }
        }
      }
      return false;
    }
  } catch (Exception $e){
    return false;
  }
}

//function to select the newest date
function newestDate($dateArray){
  for ($i=0;$i<sizeof($dateArray); $i++){

    $dates[$i] = date( "d.m.Y", strtotime( $dateArray[$i] ) );
    //echo "NEWEST**: ".$dates[$i]."**";
  }
  $newest = max($dates);
  return $newest;
}

//main function
function mainConvert($filePath, $colNum, $colNameArray){
  // Include Composer autoloader if not already done.
  include 'vendor/autoload.php';
  include 'vendor1/autoload.php';

  //**************Create a workbook for EXCEL OPEARTION**************
  $workbook = new Spreadsheet_Excel_Writer('TMPO.xls');

  //sending HTTP headers
  //$workbook->send('test.xls');

  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('TM Purchase Order');

  // Editing the title
  $col0 = "PO Number";
  $col1 = "PO Date";
  $col2 = "Contract No";
  $col3 = "Payment Terms";
  $col4 = "Project/Cost Center";
  $col5 = "Tracking No";
  $col6 = "Project Manager";
  $col7 = "Contact Person";
  $col8 = "Contact No";
  $col9 = "Delivery Date";
  $col10 = "Total Amount (RM)";

  //set column width
  $worksheet->setColumn(0,$colNum-1,20);

  //set column title
  for ($i = 0; $i<$colNum; $i++){
    $worksheet->write(0, $i, $colNameArray[$i]);
  }
  //**************************************************************

  //retrieve file in filePath array and then extract data into excel
  $row = 1;
  for($curFile = 0 ; $curFile <sizeof($filePath); $curFile++){
    // Parse pdf file and build necessary objects.
    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($filePath[$curFile]);

    $pages = $pdf->getPages();

    //Loop over each page to extract text
    $countPage = 1;
    $deliIndex = 0;
    foreach($pages as $page){
      $text = $page->getText();
    //echo $text;

    //Only extract the info once
    echo "count page: ".$countPage;
    if($countPage == 1){
      //Extract information
      //PO NUMBER extraction:
      $pos = strpos($text,"PO Number :");
      $start = $pos + 12;
      $PONumber = getInformationString($start, $text);
      echo $PONumber;
      //echo "\n";
      //PO DATE extraction
      $pos = strpos($text,"PO Date :");
      $start = $pos + 10;
      $PODate = getInformationString($start, $text);
      echo $PODate;
      //Contract No extraction
      $pos = strpos($text,"Contract No :");
      $start = $pos + 14;
      $ContractNo = getInformationString($start, $text);
      echo $ContractNo;
      //Payment Terms extraction
      $pos = strpos($text,"Payment Terms :");
      $start = $pos + 16;
      $PayTerms = getInformationString($start, $text);
      echo $PayTerms;
      //Project/Cost Center extraction
      $pos = strpos($text,"Project/Cost Center :");
      $start = $pos + 22;
      $ProjCostCenter = getInformationString($start, $text);
      echo $ProjCostCenter;
      //Tracking No extraction
      $pos = strpos($text,"Tracking No :");
      $start = $pos + 14;
      $TrackingNo = getInformationString($start, $text);
      echo $TrackingNo;
      //Project Manager extraction
      $pos = strpos($text,"Project Manager :");
      $start = $pos + 18;
      $ProjectManager = getInformationString($start, $text);
      echo $ProjectManager;
      //Contact Person extraction
      $pos = strpos($text,"Contact Person  :");
      $start = $pos + 18;
      $ContactPerson = getInformationString($start, $text);
      echo $ContactPerson;
      //Contact No extraction
      $pos = strpos($text,"Contact No     :");
      $start = $pos + 17;
      $ContactNo = getInformationString($start, $text);
      echo "&&&&&&: ".$ContactNo."&&";
      for ($i = 0; $i <strlen($ContactNo); $i++){
        if($ContactNo[0] == '+'){
          if(!is_numeric($ContactNo[$i+1])){
            $i++;
            break;
          }
        }else{
          if(!is_numeric($ContactNo[$i])){
            break;
          }
        }
      }
      $ContactNo = substr($ContactNo,0,$i);
      echo $ContactNo;
    }

    //Total Amount extraction
    //Only do extraction if keyword is found
    if(strpos($text,"Total Amount   MYR   :") == true){
      $pos = strpos($text,"Total Amount   MYR   :");
      $start = $pos + 24;
      $TotalAmount = getInformationString($start, $text);
      echo "\n";
      echo $TotalAmount;
    }


    //Extract delivery date at every page

    //$pos = strpos($text,"The Item covers the following  services");

    //$endSectionPos = strpos($text,"Total Amount   MYR   :");
    $endSectionPos = strlen($text);
    $len = $endSectionPos - 0;
    $tableSection = substr($text,0,$len);
    $array = explode(" ", $tableSection);
     for ($i =0; $i < sizeof($array);$i++){
       //echo $array[$i];
       //echo "\n";

       if (isDate($array[$i]) == true) {
         $deliDate[$deliIndex] = $array[$i];
         echo "correct: ".$deliIndex." ".$deliDate[$deliIndex];
         $deliIndex ++;
         echo "\n";
       }
     }
     //testing..
     //$testDate[0]="12.1.2017";
     //$testDate[1]="12.1.2018";
     //$testDate[2]="3.3.2017";
     //$testDate[3]="11.1.2017";

     //echo "DATE$$: ".$newDate.'$$';

     $countPage = $countPage + 1;
  }
  //get newest date from collected array of date
  $newDate = newestDate($deliDate);
  //write to excel
  for ($col =0;$col <$colNum; $col++){
    if ($colNameArray[$col] == "PO Number"){
      $worksheet->write($row,$col, $PONumber);
    }else if ($colNameArray[$col] == "PO Date"){
        $worksheet->write($row,$col, $PODate);
      }
    else if ($colNameArray[$col] == "Contract No"){
        $worksheet->write($row,$col, $ContractNo);
      }
    else if ($colNameArray[$col] == "Payment Terms"){
        $worksheet->write($row,$col, $PayTerms);
      }
    else if ($colNameArray[$col] == "Project/Cost Center"){
        $worksheet->write($row,$col, $ProjCostCenter);
      }
    else if ($colNameArray[$col] == "Tracking No"){
        $worksheet->write($row,$col, $TrackingNo);
      }
    else if ($colNameArray[$col] == "Project Manager"){
        $worksheet->write($row,$col, $ProjectManager);
      }
    else if ($colNameArray[$col] == "Contact Person"){
        $worksheet->write($row,$col, $ContactPerson);
      }
    else if ($colNameArray[$col] == "Contact No"){
        $worksheet->write($row,$col, $ContactNo);
      }
    else if ($colNameArray[$col] == "Delivery Date"){
        $worksheet->write($row,$col, $newDate);
      }
    else {
        $worksheet->write($row,$col, $TotalAmount);
      }
    }

  $row = $row + 1;
}//close of fileLoop
  // Let's send the file
  $workbook->close();

  return true;
}
?>
