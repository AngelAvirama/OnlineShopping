<?php
session_start();
include("../db.php");
error_reporting(0);

// Eliminar producto
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete') {
    $product_id = $_GET['product_id'];
    
    // Eliminar imagen del producto
    $result = mysqli_query($con, "SELECT product_image FROM products WHERE product_id='$product_id'") or die("Query is incorrect...");
    list($picture) = mysqli_fetch_array($result);
    $path = "../product_images/$picture";

    if(file_exists($path) == true) {
        unlink($path);
    }

    // Eliminar producto de la base de datos
    mysqli_query($con, "DELETE FROM products WHERE product_id='$product_id'") or die("Query is incorrect...");
}

// Paginación
$page = $_GET['page'];
if ($page == "" || $page == "1") {
    $page1 = 0;
} else {
    $page1 = ($page * 10) - 10;
}

include "sidenav.php";
include "topheader.php";
?>

<div class="content">
    <div class="container-fluid">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Products List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table tablesorter" id="page1">
                            <thead class="text-primary">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Obtener lista de productos
                                $result = mysqli_query($con, "SELECT product_id, product_image, product_title, product_price FROM products WHERE product_cat=2 OR product_cat=3 OR product_cat=4 LIMIT $page1, 12") or die("Query 1 incorrect...");
                                while (list($product_id, $image, $product_name, $price) = mysqli_fetch_array($result)) {
                                    echo "<tr>
                                            <td><img src='../product_images/$image' style='width:50px; height:50px; border:groove #000'></td>
                                            <td>$product_name</td>
                                            <td>$price</td>
                                            <td>
                                                <a class='btn btn-success' href='editproduct.php?product_id=$product_id'>Edit</a>
                                                <a class='btn btn-danger' href='#' onclick='confirmDelete($product_id)'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php
                    // Contando el número de páginas
                    $paging = mysqli_query($con, "SELECT product_id FROM products");
                    $count = mysqli_num_rows($paging);
                    $a = ceil($count / 12);
                    for ($b = 1; $b <= $a; $b++) {
                        echo "<li class='page-item'><a class='page-link' href='productlist.php?page=$b'>$b</a></li>";
                    }
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Confirmación de eliminación -->
<script>
function confirmDelete(productId) {
    if (confirm("Are you sure you want to delete this product? This action cannot be undone.")) {
        window.location.href = "productlist.php?product_id=" + productId + "&action=delete";
    }
}
</script>

<?php
include "footer.php";
?>
