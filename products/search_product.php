<?php
include_once '../classes/product.class.php';
//include_once '../classes/class.inventory.php';
//include '../config/config.php';
$product = new Product();
//$inventory = new Inventory();

// get the q parameter from URL
$q = $_GET["q"];
$count = 1;
$hint='
<table id="product-list">
        <th class="id">#</th>
        <th class="name">Product Name</th>
        <th class="price">Product Price</th>
        <th class="desc">Description</th>
        <th class="status">Status</th>
</tr>';
$data = $product->list_product_search($q);
if($data != false){
    //$hint = '<ul>';
    foreach($data as $value){
        extract($value);

        $status ="";

        if($product_status == "0"){
          $status ="Available";
        }else{
          $status ="Not Available";
        }
        
        //$hint .= '<li>'.$prod_name. '</li>';
        $hint .= '
        <tr>
        <td class="center">'.$count.'</td>
        <td><a href="index.php?page=products&action=profile&id='.$product_id.'">'.$product_name.'</a></td>
        <td>'.$product_price.'</td>
        <td>'.$product_desc.'</td>
        <td>'.$status.'</td>
      </tr>';
        $count++;
    }
}
$hint .= '</table>
';

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "No result(s)" : $hint;
?>