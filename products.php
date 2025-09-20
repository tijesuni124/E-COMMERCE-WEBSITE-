 <?php 
session_start();
include("includes/header.php");

$data = json_decode(file_get_contents("products.json"), true);
$products = $data['products'];

$cat = $_GET['cat'] ?? 'men';

echo "<h2 class='mb-4'>Products - ".ucfirst($cat)."</h2>";
echo "<div class='row'>";
foreach ($products[$cat] as $p) {
    echo "<div class='col-md-4 mb-3'>
            <div class='card h-100'>
              <img src='{$p['image']}' class='card-img-top' alt='{$p['name']}'>
              <div class='card-body'>
                <h5 class='card-title'>{$p['name']}</h5>
                <p class='card-text'>₦{$p['price']}</p>
                <a href='add-to-cart.php?id={$p['id']}' class='btn btn-success'>Add to Cart</a>
              </div>
            </div>
          </div>";
}
echo "</div>";

include("includes/footer.php");
?>