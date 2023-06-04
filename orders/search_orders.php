<?php
include_once '../classes/order.class.php';
//include_once '../classes/class.inventory.php';
//include '../config/config.php';
$order = new Order();
//$inventory = new Inventory();

// get the q parameter from URL
$q = $_GET["q"];
$count = 1;
$hint='
<table id="order-list">
    <tr>
        <th class="id">#</th>
        <th class="orderid">Order Id</th>
        <th class="clientid">Client</th>
        <th class="productid">Contact</th>
        <th class="orderamount">Email</th>
        <th class="clientadd">Client Address</th>
        <th class="date">Date Created</th>
        <th class="status">Status</th>
    </tr>';
$data = $order->list_orders_search($q);
if($data != false){
    //$hint = '<ul>';
    foreach($data as $value){
        extract($value);
        $status = "";
        $link = "";
        if($order_status == '0'){
            $status = "On Going";
            $link = "index.php?page=orders&action=additems&id=";

        }else{
            $status = "Completed";
            $link = "index.php?page=orders&action=completeprofile&id=";
        }
        //$hint .= '<li>'.$prod_name. '</li>';
        $hint .= '
        <tr>
            <td class="center">'.$count.'</td>
            <td class="center">
            <a href="'.$link.$order_id.'">'.$order_id.'</a>
            </td>
            <td class="center">'.$client_firstname.', '.$client_lastname.'</td>
            <td class="center">'.$client_phone.'</td>
            <td class="center">'.$client_email.'</td>
            <td>'.$client_address.'</td>
            <td class="center">'.$order_date_added.'</td>
            <td class="center">'.$status.'</td>
      </tr>';
        $count++;
    }
}
$hint .= '</table>
';

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "No result(s)" : $hint;
?>