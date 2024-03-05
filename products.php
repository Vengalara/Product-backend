<?php
session_start();

include("includes/header.php"); 
include("classes/db_conn.php"); 
include("classes/product.php"); 

$db_conn = new DatabaseConn();

$product = new Product($db_conn->get_db_conn()); 

$search = isset($_GET['search']) ? $_GET['search'] : null;
$on_sale = isset($_GET['onsale']) ? $_GET['onsale'] : null;
$category = isset($_GET['pcategory']) ? $_GET['pcategory'] : null;

$products = $product->get_all_products($search, $category, $on_sale);

$categories = $product->get_products_categories();

?>



<!-- Product Grid -->
<div class="container mt-5">

   <h2 class="text-center mb-4">All Products</h2>
   
   <?php
   
    if(isset($_GET["msg"]) && $_GET["msg"] == "success" ){
        
        echo '<p class="fw-bold text-success text-center mb-3">Product Added to Cart.<p>';

    }

    if(isset($_GET["search"])){
        
      echo '<p class="lead text-center mb-3">Search results for: ' . htmlentities($_GET['search']) .'<p>';

  }
    
   ?>



<div class="mx-auto accordion mb-4" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button bg-light fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Filter Products
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            
          
          <form class="d-flex">

                <div class="input-group">
                    <div class="input-group-text">
                        <span class="me-2">ON SALE</span>
                        <input class="form-check-input mt-0" type="checkbox" value="1" name="onsale" 
                        aria-label="Checkbox for following text input">
                    </div>
                    
                    <select class="form-select" id="categorySelect" name="pcategory">
                            <option value="">All Categories</option>
                            
                            <?php foreach($categories as $category){ ?>
                                <option value="<?php echo $category[0]; ?>" <?php echo isset($_GET['pcategory']) && $_GET['pcategory'] == $category[0]  ? 'selected' : ''; ?>>
                                  <?php echo $category[0]; ?>
                                </option>
                            <?php  } ?>
                    </select>

                </div>

                <button type="submit" class="btn btn-success ms-2">Filter</button>
                <a href="products.php" class="btn btn-outline-success ms-1">Reset</a>

            </form>



          </div>
        </div>
      </div>
    </div>





    <div class="row">
        
        <?php foreach($products as $product){ ?>

            <!-- Product Card  -->
            <div class="col-md-4 mb-4">
               
              <?php include("includes/card.php"); ?>

            </div>

        <?php } ?>

    </div>


</div>

<?php include("includes/footer.php"); ?>
