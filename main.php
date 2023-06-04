<?php
//Include class files to be used in page and following sub pages
include_once 'classes/product.class.php';
include_once 'classes/order.class.php';
include_once 'classes/class.user.php';

/* instantiate class objects */
$product = new Product();
$order = new Order();

$con = new mysqli('localhost','root','', 'cakes&crafts_db');
$query = $con->query("SELECT COUNT(*) AS number, MONTHNAME(order_date_added) AS date FROM tbl_orders GROUP BY MONTHNAME(order_date_added);");

foreach($query as $data){
  $month[] = $data['date'];
  $amount[] = $data['number'];
}

$query2 = $con->query("SELECT COUNT(*) AS number2, MONTHNAME(completed_date_added) AS date2 FROM tbl_order_complete GROUP BY MONTHNAME(completed_date_added);");
foreach($query2 as $data){
  $month2[] = $data['date2'];
  $amount2[] = $data['number2'];
}
?>

<div class="content-main">
    <div class="main-home">

<div class="prev-block">
    <div class="prev-header">
        <h1>Orders</h1>
        
    </div>
    

    <table id="order-list">
      <tr>
        <th class="id">#</th>
        <th class="orderid">Order Id</th>
        <th class="clientid">Client</th>
        <th class="productid">Contact</th>
        <th class="orderamount">Email</th>
        <th class="totalprice">Date Created</th>
      </tr>
<?php
// CALLS LIST FUNCTION OF ORDERS TO DISPLAY DATA 
$count = 1;
if($order->list_order() != false){
foreach($order->list_order() as $value){
   extract($value);
  
?>
      <tr>
        <td class="center"><?php echo $count;?></td>
        <td class="center"><a href="index.php?page=orders&action=additems&id=<?php echo $order_id;?>"><?php echo $order_id;?></a></td>
        <td class="center"><?php echo $client_firstname.', '.$client_lastname;?></td>
        <td class="center"><?php echo $client_phone;?></td>
        <td class="center"><?php echo $client_email;?></td>
        <td class="center"><?php echo $order_date_added;?></td>
      </tr>
      <tr>
<?php
 $count++;
}
}else{
  echo "No Record Found.";
}
?>
    </table>
</div>
  <?php if($user->get_user_access($user_id) === "Supervisor" || $user->get_user_access($user_id) === "Manager"){?>

    <div class="reports-block">
      <div class="prev-block2">
        <canvas id="myChart"></canvas>
      </div>

      <div class="prev-block2">
        <canvas id="myChart2"></canvas>
      </div>
    </div>

  <?php }else{}?>
</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');
  

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($month) ?>, //['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: 'Monthly Orders',
        data: <?php echo json_encode($amount) ?>,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($month2) ?>, //['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: 'Completed Orders',
        data: <?php echo json_encode($amount2) ?>,
        backgroundColor: '#00FF00',
        borderWidth: 1,
       
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>