<?php
  session_start();

  if(!isset($_SESSION['indexFile'])){
    $_SESSION['indexFile'] = 0;
  }
  if(isset($_POST['Clearbutton'])){
    $_SESSION['clearBtn'] = $_POST['Clearbutton'];
  }
  if(isset($_POST['Importbutton'])){
    $_SESSION['importBtn'] = $_POST['Importbutton'];
  }
  $_SESSION['arraySize'] = sizeof($_FILES["fileToUpload"]['name']);

  $target_dir = "uploads/";
  $_SESSION['dupResult'] = "";
  $tempIndex = 0;
  $tempFileName =[];

  if(isset($_POST['Importbutton'])){
    header('Location: index.php');
    for ($i =0; $i <sizeof($_FILES["fileToUpload"]['name']);$i++){

      //check for duplicate
      $temporary = $target_dir.$_FILES["fileToUpload"]['name'][$i];
      $duplicate = false;

      if($_SESSION['indexFile'] !== 0){
        for($k = 0;$k <$_SESSION['indexFile']; $k++){
          if($temporary == $_SESSION['filePath'][$k]){
            $duplicate = true;
          }
        }
      }
      $_SESSION['temPath'][$_SESSION['indexFile']]= $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);

      if($duplicate == true){
        $_SESSION['dupResult'] = $_SESSION['dupResult'].$_FILES["fileToUpload"]['name'][$i]." is a duplicated upload!\n";
        $tempFileName[$i] = "Duplicate Upload: ".basename($_FILES["fileToUpload"]["name"][$i]);
      }else{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $_SESSION['temPath'][$_SESSION['indexFile']])) {
          $_SESSION['filePath'][$_SESSION['indexFile']]= $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
          $tempFileName[$i] = "Successful Upload: ".basename($_FILES["fileToUpload"]["name"][$i]);
          $_SESSION['indexFile'] = $_SESSION['indexFile'] + 1;
        }
        else {
          echo "<script>alert('Sorry, there was an error importing your file.')</script>";
          $tempFileName[$i] = "failed";
        }
      }


    }


  }

  if(isset($_POST['Clearbutton'])){
    header('Location: index.php');

    //unlink files
    for($j=0;$j<$_SESSION['indexFile'];$j++){
      unlink($_SESSION['filePath'][$j]);
    }
    //clear variables
    unset($_SESSION['arraySize']);
    unset($_SESSION['filePath']);
    unset($_SESSION['fileName']);
    unset($_SESSION['indexFile']);
  }

  //$_SESSION['filePath'] = $target_file; //accumulative array

  $_SESSION['fileName'] = $tempFileName; //change every import

  /*if(isset($_POST['Importbutton'])){
    $_SESSION['importBtn']= $_POST['Importbutton'];
  }*/


  //$_SESSION['output'] = "Total of ".$_SESSION['arraySize']." files have been imported!";






?>
