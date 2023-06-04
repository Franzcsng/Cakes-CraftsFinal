<script>
function showResults(str) {
  if (str.length == 0) {
    document.getElementById(\"search-result\").innerHTML = \"\";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(\"search-result\").innerHTML = this.responseText;
      }
    };
    xmlhttp.open(\"GET\", \"products/search_product.php?q=\" + str, true);
    xmlhttp.send();
  }
}
</script>

<?php
include_once 'classes/product.class.php';
include_once 'classes/class.user.php';
/* instantiate class object */
$product = new Product();
$user = new User();
?>
<div class="content-main">
    <div class="subclass-nav">
        <a href="index.php?page=products&action=view">products</a>

<?php if($user->get_user_access($user_id) === "Supervisor"){?>
          <a href="index.php?page=products&action=create">add product</a>
<?php }else{} ?>
    </div>
  

    <div class="content-main2">
    <?php
                switch($action){
                case 'create':
                    require_once 'products/create-product.php';
                break; 
                case 'profile':
                    require_once 'products/product-profile.php';
                break;
                case 'view':
                    require_once 'products/view-products.php';
                break; 
                default:
                    require_once 'products/view-products.php';
                break;
            }
    ?>
    </div>
    
</div>