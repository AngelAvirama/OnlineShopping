<?php
session_start();
include("../db.php");
$product_id=$_REQUEST['product_id'];

$result=mysqli_query($con,"select product_id, product_title, product_price, product_image from products where product_id='$product_id'")or die ("query 1 incorrect.......");

list($product_id, $product_name, $product_price, $product_image) = mysqli_fetch_array($result);

if(isset($_POST['btn_save'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_FILES['product_image']['name'];

  // If a new image is uploaded, process it
  if ($product_image != "") {
    $target_dir = "../product_images/";
    $target_file = $target_dir . basename($product_image);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
  } else {
    $product_image = $product_image;  // Retain the existing image
  }

  mysqli_query($con, "UPDATE products SET product_title='$product_name', product_price='$product_price', product_image='$product_image' WHERE product_id='$product_id'") or die("Query 2 is incorrect..........");

  header("location: productlist.php");
  mysqli_close($con);
}
include "sidenav.php";
include "topheader.php";
?>
<div class="content">
  <div class="container-fluid">
    <div class="col-md-5 mx-auto">
      <div class="card">
        <div class="card-header card-header-primary">
          <h5 class="title">Edit Product</h5>
        </div>
        <form action="editproduct.php" name="form" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />
            <div class="col-md-12 ">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" value="<?php echo $product_name; ?>" >
              </div>
            </div>
            <div class="col-md-12 ">
              <div class="form-group">
                <label>Price</label>
                <input type="text" id="product_price" name="product_price" class="form-control" value="<?php echo $product_price; ?>" >
              </div>
            </div>
            <div class="col-md-12 ">
              <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" >
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" id="btn_save" name="btn_save" class="btn btn-fill btn-primary">Update</button>
          </div>
        </form>    
      </div>
    </div>
  </div>
</div>
<?php
include "footer.php";
?>
