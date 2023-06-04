<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=".date("Y-m-d")."-order-report.xls");

include_once '../classes/order.class.php';
include '../config/config.php';

$order = new Order();

echo '#' . "\t" . 'ID' . "\t" . 'Client' . "\t" . 'Contact' . "\t" . 'E-Mail' . "\t" . 'Date Created' . "\t" . 'Status' . "\n";

$count = 1;
$status ="";
if($order->list_order() != false){
    foreach($order->list_order() as $value){
        extract($value);
        if($order_status == "0"){
            $status ="On Going";
        }else{
            $status ="Completed";
        }
                
            echo $count . "\t" . $order_id. "\t".$client_firstname.", ".$client_lastname . "\t" . $client_phone . "\t" . $client_email . "\t" .$order_date_added. "\t" .$status. "\n";
            
                $count++;
        
    }
}
?>