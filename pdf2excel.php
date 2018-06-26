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

  //set date format
  $date_format = $workbook->addFormat(array('size'=>9,
  'align'=>'left'));
  $date_format ->setNumFormat('MM/DD/YYYY');

  //set text Format
  $columnTitleFormat = $workbook->addFormat(array('bold'=>1,
  'top'=>1,
  'bottom'=>1 ,
  'size'=>10,
  'FgColor' => 'cyan'));

  $regularFormat = $workbook->addFormat(array('size'=>9,
  'align'=>'left'));


  //set column title
  for ($i = 0; $i<$colNum; $i++){
    $worksheet->write(0, $i, $colNameArray[$i],$columnTitleFormat);


    //set width according to columnName
    if ($colNameArray[$i] == "PO Number"){
      //echo $i;
      $worksheet->setColumn($i,$i,12);
    }else if ($colNameArray[$i] == "PO Date"){
        $worksheet->setColumn($i,$i,10.8);
      }
    else if ($colNameArray[$i] == "Contract No"){
        $worksheet->setColumn($i,$i,11);
      }
    else if ($colNameArray[$i] == "Payment Terms"){
        $worksheet->setColumn($i,$i,28);
      }
      else if ($colNameArray[$i] == "Incoterms"){
          $worksheet->setColumn($i,$i,24.6);
        }
    else if ($colNameArray[$i] == "Project"){
        $worksheet->setColumn($i,$i,13.3);
      }
    else if ($colNameArray[$i] == "Cost Center"){
          $worksheet->setColumn($i,$i,44);
      }
    else if ($colNameArray[$i] == "Tracking No"){
        $worksheet->setColumn($i,$i,11);
      }
    else if ($colNameArray[$i] == "Project Manager"){
        $worksheet->setColumn($i,$i,30);
      }
    else if ($colNameArray[$i] == "Contact Person"){
        $worksheet->setColumn($i,$i,30);
      }
    else if ($colNameArray[$i] == "Contact No"){
        $worksheet->setColumn($i,$i,13);
      }
    else if ($colNameArray[$i] == "Delivery Date"){
        $worksheet->setColumn($i,$i,12);
      }
    else {
        $worksheet->setColumn($i,$i,12);
      }
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
    $array = []; //initialise array
    $deliDate = [];
    $countPage = 1;
    $deliIndex = 0;
    foreach($pages as $page){
      $text = $page->getText();
    //echo $text;

    //Only extract the info once
    //echo "count page: ".$countPage;
    if($countPage == 1){
      //Extract information
      //PO NUMBER extraction:
      $pos = strpos($text,"PO Number :");
      $start = $pos + 12;
      $PONumber = getInformationString($start, $text);

      //PO DATE extraction
      $pos = strpos($text,"PO Date :");
      $start = $pos + 10;
      $PODate = getInformationString($start, $text);
      $PODate = date("m/d/Y",strtotime($PODate));

      //Contract No extraction
      $pos = strpos($text,"Contract No :");
      $start = $pos + 14;
      $ContractNo = getInformationString($start, $text);

      //Payment Terms extraction
      $pos = strpos($text,"Payment Terms :");
      $start = $pos + 16;
      $PayTerms = getInformationString($start, $text);

      //Incoterms extraction
      $pos = strpos($text,"Incoterms :");
      $start = $pos + 12;
      $Incoterms = getInformationString($start, $text);

      //Project/Cost Center extraction
      $pos = strpos($text,"Project/Cost Center :");
      $start = $pos + 22;
      //special case because might elongate to next row
      $estimatedLen = 100;
      $tempStr = substr($text, $start, $estimatedLen);
      $back = strpos($tempStr, "Tracking No :");
      $ProjCostCenter = substr($tempStr, 0,$back);
      $ProjCostCenter = str_replace("\n"," ",$ProjCostCenter);
      //separation of project & Cost Center
      if(strpos($ProjCostCenter," ") == true){
        $next = strpos($ProjCostCenter," ") + 1;
        $Project = substr($ProjCostCenter,0,strpos($ProjCostCenter, " "));
        $Project = trim($Project);
        $len = strlen($ProjCostCenter) - $next;
        $CostCenter = substr($ProjCostCenter, $next,$len );
        $CostCenter = trim($CostCenter);
      }else {
        //only got Project
        $Project = trim($ProjCostCenter);
        $CostCenter = "";
      }

      //Tracking No extraction
      $pos = strpos($text,"Tracking No :");
      $start = $pos + 14;
      $TrackingNo = getInformationString($start, $text);

      //Project Manager extraction
      $pos = strpos($text,"Project Manager :");
      $start = $pos + 18;
      //special case because might elongate to next row
      $estimatedLen = 100;
      $tempStr = substr($text, $start, $estimatedLen);
      $back = strpos($tempStr, "Contact Person  :");
      $ProjectManager = substr($tempStr, 0,$back);
      $ProjectManager = str_replace("\n"," ",$ProjectManager);
      $ProjectManager = str_replace("  "," ",$ProjectManager);
      if(strpos($ProjectManager,"-") == true){
        $temp= explode("-", $ProjectManager);
        $ProjectManager = $temp[1];
      }

      //Contact Person extraction
      $pos = strpos($text,"Contact Person  :");
      $start = $pos + 18;
      //special case because might elongate to next row
      $estimatedLen = 100;
      $tempStr = substr($text, $start, $estimatedLen);
      $back = strpos($tempStr, "Contact No     :");
      $ContactPerson = substr($tempStr, 0,$back);
      $ContactPerson = str_replace("\n"," ",$ContactPerson);
      $ContactPerson = str_replace("  "," ",$ContactPerson);

      //Contact No extraction
      $pos = strpos($text,"Contact No     :");
      $start = $pos + 17;
      $ContactNo = getInformationString($start, $text);
      for ($i = 0; $i <strlen($ContactNo); $i++){
        if($ContactNo[0] == '+'){
          if(is_numeric($ContactNo[$i+1]) || $ContactNo[$i+1] == '-' || $ContactNo[$i+1] == ' '){
          }else{
            $i++;
            break;
          }
        }else{
          if(is_numeric($ContactNo[$i]) || $ContactNo[$i] == '-' || $ContactNo[$i] == ' '){
          }else{
            break;
          }
        }
      }
      $ContactNo = substr($ContactNo,0,$i);
    }

    //Total Amount extraction
    //Only do extraction if keyword is found
    if(strpos($text,"Total Amount   MYR   :") == true){
      $pos = strpos($text,"Total Amount   MYR   :");
      $start = $pos + 24;
      $TotalAmount = getInformationString($start, $text);
      $TotalAmount = trim($TotalAmount);
      //echo "\n";
      //echo $TotalAmount;
    }

    //Subtotal extraction
    //Only do extraction if keyword is found
    if(strpos($text,"Subtotal") == true){
      $pos = strpos($text,"Subtotal");
      $start = $pos + 9;
      $Subtotal = getInformationString($start, $text);
      $Subtotal = trim($Subtotal);
      //echo "\n";
      //echo $TotalAmount;
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
         //echo "correct: ".$deliIndex." ".$deliDate[$deliIndex];
         $deliIndex ++;
         //echo "\n";
       }
     }
     //testing..
     //$testDate[0]="12.1.2017";
     //$testDate[1]="12.1.2018";
     //$testDate[2]="3.3.2017";
     //$testDate[3]="11.1.2017";

     $countPage = $countPage + 1;
  }

  //get newest date from collected array of date
  $newDate = newestDate($deliDate);
  $newDate = date("m/d/Y",strtotime($newDate));

  //write to excel
  for ($col =0;$col <$colNum; $col++){
    if ($colNameArray[$col] == "PO Number"){
      $worksheet->write($row,$col, $PONumber,$regularFormat);
    }else if ($colNameArray[$col] == "PO Date"){
        $worksheet->write($row,$col, "=DATEVALUE(\"$PODate\")",$date_format);
      }
    else if ($colNameArray[$col] == "Contract No"){
        $worksheet->write($row,$col, $ContractNo,$regularFormat);
      }
    else if ($colNameArray[$col] == "Payment Terms"){
        $worksheet->write($row,$col, $PayTerms,$regularFormat);
      }
    else if ($colNameArray[$col] == "Project"){
        $worksheet->write($row,$col, $Project,$regularFormat);
      }
    else if($colNameArray[$col] == "Cost Center"){
        $worksheet->write($row,$col, $CostCenter,$regularFormat);
      }
    else if ($colNameArray[$col] == "Tracking No"){
        $worksheet->write($row,$col, $TrackingNo,$regularFormat);
      }
    else if ($colNameArray[$col] == "Project Manager"){
        $worksheet->write($row,$col, $ProjectManager,$regularFormat);
      }
    else if ($colNameArray[$col] == "Contact Person"){
        $worksheet->write($row,$col, $ContactPerson,$regularFormat);
      }
    else if ($colNameArray[$col] == "Contact No"){
        $worksheet->write($row,$col, $ContactNo,$regularFormat);
      }
    else if ($colNameArray[$col] == "Delivery Date"){
        $worksheet->write($row,$col, "=DATEVALUE(\"$newDate\")",$date_format);
      }
      else if($colNameArray[$col] == "Incoterms"){
        $worksheet->write($row,$col, $Incoterms,$regularFormat);
      }
      else if($colNameArray[$col] == "Subtotal"){
        $worksheet->write($row,$col, $Subtotal,$regularFormat);
      }
    else {
        $worksheet->write($row,$col, $TotalAmount,$regularFormat);
      }
    }

  $row = $row + 1;
  //echo "End of one file!<br>";
}//close of fileLoop
  // Let's send the file
  $workbook->close();

  return true;
}


?>
