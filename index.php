<?php
    
    $connect = new PDO("mysql:host=localhost;dbname=db_php_development", "root", "root");
    
    function fill_unit_select_box($connect){
        
        $output = '';
        $query = "select * from unit order by unit_name asc";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row){
            $output .='<option value="'.$row["unit_name"].'">'.$row["unit_name"].'</option>';
        }
        return $output;
    }
    
    
?>
<html>
    <head>
        <title>Dynamic Box Using Ajax</title> 
        <script type="text/javascript" src="assets/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap.min.js"></script>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <br/>
        <div class="container">
            <div class="container-fluid">
                <h3 align="center">Dynamic Box Using Ajax</h3>
                <br/>
                <h4 align="center">Enter Items Details</h4>
                <br/>
                <form method="post" id="insert_form">
                    <div class="table-responsive">
                        <span id="error"></span>
                        <table class="table table-striped table-bordered table-hover" id="item_table">
                            <tr>
                                <th>Enter Item Name</th>
                                <th>Enter Quantity</th>
                                <th>Select Unit</th>
                                <th>
                                    <button type="button" 
                                            name="add"
                                            class="btn btn-success btn-sm add">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </th>
                            </tr>
                        </table>
                        <br/>
                        <div align="center">
                            <input type="submit" class="btn btn-info" 
                                   name="submit" value="Insert">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--JAVA SCRIPT HOLIC-->
        <script type="text/javascript">
            $(document).ready(function(){
               $(document).on('click', '.add', function(){
                  var html = '';
                  html += '<tr>';
                  html += '<td><input type="text" name="item_name[]" class="form-control item_name"></td>';
                  html += '<td><input type="text" name="item_quantity[]" class="form-control item_quantity"></td>';
                  html += '<td><select name="item_unit[]" class="form-control item_unit">';
                  html += '<option value="">Select Unit</option><?php echo fill_unit_select_box($connect);?>';
                  html += '</select></td>';
                  html += '<td>';
                  html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove">';
                  html += '<span class="glyphicon glyphicon-minus">';
                  html += '</span>';
                  html += '</button>';
                  html += '</td>';
                  html += '</tr>';
                  
                  $('#item_table').append(html);
                  
               });
               
               $(document).on('click', '.remove', function(){
                  $(this).closest('tr').remove(); 
               });
               
               $("#insert_form").on('submit', function(event){
                   event.preventDefault();
                   var error = '';
                   $('.item_name').each(function (){
                      var count = 1;
                      if($(this).val() == ''){
                          error += "<p>Masukkan Item Nama di baris "+count+" !</p>";
                          return false;
                      }
                      count = count + 1;
                   });
                   
                   $('.item_quantity').each(function(){
                      var count = 1;
                      if($(this).val() == ''){
                          error += "<p>Masukkan Item Quantity/Jumlah di baris "+count+" !</p>";
                          return false;
                      }
                      count = count + 1;
                   });
                   
                   $('.item_unit').each(function(){
                     var count = 1;
                     if($(this).val() == ''){
                         error += "<p>Unit Name belum dipilih di baris "+count+" !</p>";
                         return false;
                     }
                     count = count + 1;
                   });
                   
                   var form_data = $(this).serialize();
                   
                   if(error == ''){
                   
                       $.ajax({
                          url: "insert.php",
                          method: "POST",
                          data: form_data,
                          success: function(data){
                              
                              if(data == 'ok'){
                               $("#item_table").find("tr:gt(0)").remove();
                               $("#error").html("<div class='alert alert-success'>\n\
                                    Data berhasil disimpan di database</div>");
                              }
                          }
                       });
                       
                   }else{
                   
                      $("#error").html('<div class="alert alert-danger">'+error+'</div>');
                      
                   }
               });
               
               
               
            });
        </script>
    </body>
</html>
