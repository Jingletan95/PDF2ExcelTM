<?php
  session_start();


  $target_dir = "uploads/";
  //$arraySize

  for ($i =0; $i <sizeof($_FILES["fileToUpload"]);$i++){
    $target_file[$i]= $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
    //echo $target_file[$i];
    //echo "<br>";

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file[$i])) {
      //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      header('Location: index.php');
      //$_SESSION['filePath'] = $target_file[$i];
      //$_SESSION['fileName'] = basename($_FILES["fileToUpload"]["name"][$i]);
      $tempFileName[$i] = basename($_FILES["fileToUpload"]["name"][$i]);
    }
    else {
      echo "<script>alert('Sorry, there was an error importing your file.')</script>";
      header('Location: index.php');
      $tempFileName[$i] = "failed";
    }
  }
  $_SESSION['arraySize'] = sizeof($_FILES["fileToUpload"]);
  $_SESSION['filePath'] = $target_file;
  $_SESSION['fileName'] = $tempFileName;






?>
