<?php
  include_once 'products_crud.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Refrigerator Store Ordering System : Products</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <body style="background-color:#9FD7FC;">
   
  <?php include_once 'nav_bar.php'; 

  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
 ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Create New Product</h2>
        <?php
                if (isset($_SESSION['error'])) {
                    echo "<p id='error' class='text-danger text-center'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                ?>
      </div>
    <form action="products.php" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="form-group">
          <label for="productid" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
          <input name="pid" type="text" class="form-control" id="productid" placeholder="Product ID"  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_id']; ?>" required>
        </div>
        </div>
      <div class="form-group">
          <label for="productname" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
          <input name="name" type="text" class="form-control" id="productname" placeholder="Product Name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required>
        </div>
        </div>
        <div class="form-group">
          <label for="productprice" class="col-sm-3 control-label">Price</label>
          <div class="col-sm-9">
          <input name="price" type="number" class="form-control" id="productprice" placeholder="Product Price" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_price']; ?>" min="0.0" step="0.01" required>
        </div>
        </div>
      <div class="form-group">
          <label for="productbrand" class="col-sm-3 control-label">Brand</label>
          <div class="col-sm-9">
          <select name="brand" class="form-control" id="productbrand" required>
            <option value="">Please select</option>
            <option value="LG" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="LG") echo "selected"; ?>>LG</option>
            <option value="SAMSUNG" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="SAMSUNG") echo "selected"; ?>>SAMSUNG</option>
            <option value="SHARP" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="SHARP") echo "selected"; ?>>SHARP</option>
            <option value="TOSHIBA" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="TOSHIBA") echo "selected"; ?>>TOSHIBA</option>
          </select>
        </div>
        </div>    
        <div class="form-group">
          <label for="type" class="col-sm-3 control-label">Type</label>
          <div class="col-sm-9">
          <div class="radio">
              <label>
              <input name="type" type="radio" id="type" value="TOP FREEZER" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="TOP FREEZER") echo "checked"; ?> required> TOP FREEZER
            </label>
          </div>
          <div class="radio">
              <label>
                <input name="type" type="radio" id="type" value="BOTTOM FREEZER" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="BOTTOM FREEZER") echo "checked"; ?>> BOTTOM FREEZER
            </label>
            </div>
         <div class="radio">
              <label>
                <input name="type" type="radio" id="type" value="SIDE-BY-SIDE" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="SIDE-BY-SIDE") echo "checked"; ?>> SIDE-BY-SIDE
            </label>
            </div>
          </div>
      </div>
        <div class="form-group">
          <label for="warranty" class="col-sm-3 control-label">Warranty Length</label>
          <div class="col-sm-9">
          <select name="warranty" class="form-control" id="warranty" required>
            <option value="">Please select</option>
            <option value="2 YEAR" <?php if(isset($_GET['edit'])) if($editrow['fld_product_warranty']=="2 YEAR") echo "selected"; ?>>2 YEAR</option>
            <option value="4 YEAR" <?php if(isset($_GET['edit'])) if($editrow['fld_product_warranty']=="4 YEAR") echo "selected"; ?>>4 YEAR</option>
          </select>
        </div>
        </div>  
      <div class="form-group">
          <label for="productq" class="col-sm-3 control-label">Quantity</label>
          <div class="col-sm-9">
          <input name="quantity" type="number" class="form-control" id="productq" placeholder="Product Quantity" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_quantity']; ?>"  min="0" required>
        </div>
        </div>      
        <label for="upload" class="col-sm-3 control-label">Select image to upload:</label>
        <div class="col-sm-9">
       <div class="thumbnail dark-1">
                        <img src="products/<?php echo(isset($_GET['edit']) ? $editrow['fld_product_image'] : '') ?>"
                             onerror="this.onerror=null;this.src='products/no-photo.png';" id="productPhoto"
                             alt="Product Image" style="width: 50%;height: 225px;">
                        <div class="caption text-center">
                            <h3 id="productImageTitle" style="word-break: break-all;">Product Image</h3>
                            <p>
                                <label class="btn btn-primary">
                                    <input type="file" accept="image/*" name="fileToUpload" id="inputImage"
                                           onchange="loadFile(event);"/>

                                </label>
                            </p>
                        </div>
                    </div>
                </div>
    </div>
      </div>  
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldpid" value="<?php echo $editrow['fld_product_id']; ?>">
          <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
          <?php } else { ?>
          <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
          <?php } ?>
          <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
        </div>
      </div>
    </form>
    </div>
  </div>
  <?php } ?>
 
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Products List</h2>
      </div>
      <table class="table table-striped table-bordered">
        <tr>
          <th>Product ID</th>
          <th>Name</th>
          <th>Price(RM)</th>
          <th>Brand</th>
          <th>Type</th>
          <th>Warranty Length</th>
          <th>Quantity</th>
          <th>Image</th>
          <th></th>
        </tr>
      <?php
      // Read
      $per_page = 5;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("select * from tbl_products_a178796_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?> 
      <tr>
        <td><?php echo $readrow['fld_product_id']; ?></td>
        <td><?php echo $readrow['fld_product_name']; ?></td>
        <td><?php echo $readrow['fld_product_price']; ?></td>
        <td><?php echo $readrow['fld_product_brand']; ?></td>
        <td><?php echo $readrow['fld_product_type']; ?></td>
        <td><?php echo $readrow['fld_product_warranty']; ?></td>
        <td><?php echo $readrow['fld_product_quantity']; ?></td>
         <?php if(file_exists('products/'. $readrow['fld_product_image'])){
                $img = 'products/'.$readrow['fld_product_image'];
                echo '<td><img data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" width=150px; src="products/'.$readrow['fld_product_image'].'"></td>';
              }
              else{
                $img = 'products/nophoto.jpg';
                echo '<td><img width=70%; data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" src="products/nophoto.jpg"'.'></td>';
              }?>

              <div id="<?php echo $readrow['fld_product_id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-body">
                  <img src="<?php echo $img ?>" class="img-responsive">
                </div>
              </div>
        <td>
          <a href="products_details.php?pid=<?php echo $readrow['fld_product_id']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
          <?php
                            if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
                                ?>
                                <a href="products.php?edit=<?php echo $readrow['fld_product_id']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
                                <a href="products.php?delete=<?php echo $readrow['fld_product_id']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
 
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
          <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_products_a178796_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
          <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
          <?php } else { ?>
            <li><a href="products.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"products.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"products.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="products.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  <script type="application/javascript">
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('productPhoto');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            document.getElementById('productImageTitle').innerText = event.target.files[0]['name'];
        };
    </script>

</body>
</html>