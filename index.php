<?php
  session_start();



?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jasny-bootstrap.min.css">
    <title>PDF to Excel Converter - TM PO</title>
    <style>
      .card {
          /* Add shadows to create the "card" effect */
          box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      }
      /* Add some padding inside the card container */
      .container {
          padding: 2px 16px;
      }
    </style>
  </head>
  <body>
    <div class='container'>
      <div class='row'>
        <div class='offset-sm-2 card col-sm-8' style='margin-top: 10%;'>
          <div style='text-align: center; margin-top: 1em; margin-bottom: 1em;'>
            <img src='img/pdf2excel.png' height='130' width='150' style='margin-bottom: 1em;'>
            <h1>TM Purchase Order</h1>
            <h1>PDF to Excel Conversion</h1>
          </div>
          <h5>1. Insert your file: (Note: Maximum 20 files per selection)</h5>
          <form action='import.php' method='post' enctype="multipart/form-data">
            <div class="form-group row">
              <div class='col-sm-8' style='padding-right:1em;'>
                  <input class='form-control' type='file' name='fileToUpload[]' accept='.pdf' id='fileToUpload' multiple ='' >
                  <?php
                  $alert = "";
                    if(isset($_SESSION['arraySize'])) {
                      for ($i =0; $i <$_SESSION['arraySize'];$i++){
                        if (isset($_SESSION['fileName'][$i]) && $_SESSION['fileName'][$i]!="failed") {
                          $alert = $alert.$_SESSION['fileName'][$i].'\n';
                        }
                      }

                      //echo "<script>alert('All files have been successfully imported!')</script>";
                      //echo "<div style='text-align: center;' class=''>" .
                      if(isset($_SESSION['importBtn'])){
                        //$alert = $alert.$_SESSION['dupResult'].'\n';
                        echo "<script>alert('".$alert."')</script>";
                        echo "Total of ".($_SESSION['indexFile'] )." files have been imported!";
                        echo " *If you have more pdf files to be converted into the same current excel file, import again. ";
                        //unset($_SESSION['arraySize']);
                        //unset($_SESSION['filePath']);
                        //unset($_SESSION['fileName']);
                        //unset($_SESSION['importBtn']);

                        unset($_SESSION['importBtn']);

                      }else if(isset($_SESSION['clearBtn'])){
                        echo "Currently no files were being uploaded!";
                        unset($_SESSION['clearBtn']);
                      }
                    }
                    else{
                      echo "--Please select a file!--";
                    }
                  ?>
              </div>
              <div class='col-sm-2' style='padding-left:0'>
                 <button type='submit' name='Importbutton' class="btn btn-primary btn-block">Import</button>
              </div>
              <div class='col-sm-2' style='padding-left:0'>
                 <button type='submit' name='Clearbutton' class="btn btn-primary btn-block">Clear</button>
              </div>
            </div>
            </form>

          <form action='outputExcel.php' method ='post'>
            <div class ='row'>
              <div class='col-sm-12' style='text-align: center;'>
                <button type='submit' name = ''class='btn btn-primary btn-block'>Submit</button>
              </div>
            </div>

          </form>
     <?php
     if(isset($_SESSION['result'])){
       echo "<h1>".$_SESSION['result']."</h1>";
       echo "<h5>".$_SESSION['reason2']."</h5>";
       if( $_SESSION['dP2']== false){
         echo "<h5><a href='TMPO.xls' download>Download Excel File here!</a></h5>";
       }
       unset($_SESSION['result']);
       unset($_SESSION['reason']);
       unset($_SESSION['dP2']);
     }
     ?>
        </div> <!--card-->
      </div> <!--row biggest-->
     </div> <!--container -->

  </body>
</html>
