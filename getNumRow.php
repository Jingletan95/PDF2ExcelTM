<?php
  session_start();

  echo "Come here";

  if (isset($_POST['colNumber'])){
    header('Location: index.php');
    $_SESSION['colNum'] = $_POST['colNumber'];
  }


?>
