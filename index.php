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
      form {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
      }
    </style>
  </head>
  <body>
    <div class='container'>
      <div class='row'>

        <div class='offset-sm-2 card col-sm-8' style='margin-top: 10%;'>
          <div style='text-align: center; margin-top: 1em; margin-bottom: 1em;'>
            <img src='img/pdf2excel.png' height='110' width='150' style='margin-bottom: 1em;'>
            <h1>TM Purchase Order</h1>
            <h1>PDF to Excel Conversion</h1>
          </div>


          <form action='import.php' method='post' enctype="multipart/form-data">
          <div class='row'>
            <h5>1. Insert your file:</h5>
            <div class='col-sm-10' style='padding-right:1em;'>
              <!--<div style='text-align: center; margin-top: 1em; margin-bottom: 1em;'>-->
                <input class='form-control' type='file' name='fileToUpload[]' accept='.pdf' id='fileToUpload' multiple ='multiple' required>
                  <?php
                    if(isset($_SESSION['arraySize'])) {
                      for ($i =0; $i <$_SESSION['arraySize'];$i++){
                        if (isset($_SESSION['fileName'][$i]) && $_SESSION['fileName'][$i]!="failed") {
                          //echo "<div style='text-align: center;' class=''>" .
                          echo $_SESSION['fileName'][$i] .",";
                        }
                      }
                      echo " have been imported!";
                    }
                  ?>
             <!--</div>-->
           </div>
            <div class='col-sm-2' style='padding-left:0'>
               <button type='submit' class="btn btn-primary btn-block">Import</button>
           </div>
         </div><!--row-->
       </form>

       <h5>2. Select the required columns to generate the excel file: </h5>

       <div class="form-group row">
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col0">
             <label class="form-check-label" for="col0">
               Column 0
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col0info">
            <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
         <div class="col-sm-2 ">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col1">
             <label class="form-check-label" for="col1">
               Column 1
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col1info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col2">
             <label class="form-check-label" for="col2">
               Column 2
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col2info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col3">
             <label class="form-check-label" for="col3">
               Column 3
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col3info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col4">
             <label class="form-check-label" for="col4">
               Column 4
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col4info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col5">
             <label class="form-check-label" for="col5">
               Column 5
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col5info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col6">
             <label class="form-check-label" for="col6">
               Column 6
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col6info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col7">
             <label class="form-check-label" for="col7">
               Column 7
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col7info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col8">
             <label class="form-check-label" for="col8">
               Column 8
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col8info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
         <div class="col-sm-2">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col9">
             <label class="form-check-label" for="col9">
               Column 9
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col9info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-sm-3">
           <div class="form-check">
             <input class="form-check-input" type="checkbox" id="col10">
             <label class="form-check-label" for="col10">
               Column 10
             </label>
           </div>
         </div>
         <div class="col-sm-3">
           <select name="col10info">
             <option value="" disabled selected>Select...</option>
            <option value="PO Number">PO Number</option>
            <option value="PO Date">PO Date</option>
            <option value="Contract No">Contract No</option>
            <option value="Payment Terms">Payment Terms</option>
            <option value="Project/Cost Center">Project/Cost Center</option>
            <option value="Tracking No">Tracking No</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Contact Person">Contact Person</option>
            <option value="Contact No">Contact No</option>
            <option value="Delivery Date">Delivery Date</option>
            <option value="Total Amount">Total Amount</option>
          </select>
         </div>
       </div>


        </div> <!--card-->
      </div> <!--row biggest-->
     </div> <!--container -->

  </body>
</html>
