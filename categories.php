<?php 
include("includes/header.php");

$data = json_decode(file_get_contents("products.json"), true);
$categories = $data['categories'];

echo "<h2 class='mb-4'>Shop by Category</h2><div class='row'>";
foreach ($categories as $key => $name) {
    echo "<div class='col-md-4 mb-3'>
            <div class='card'>
              <div class='card-body text-center'>
                <h5 class='card-title'>$name</h5>
                <a href='products.php?cat=$key' class='btn btn-primary'>View</a>
              </div>
            </div>
          </div>";
}
echo "</div>";

include("includes/footer.php");
?>