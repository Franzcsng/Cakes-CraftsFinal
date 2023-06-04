<?php

class Order{
	private $DB_SERVER='localhost';
	private $DB_USERNAME='root';
	private $DB_PASSWORD='';
	private $DB_DATABASE='cakes&crafts_db';
	private $conn;
	public function __construct(){
		$this->conn = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_DATABASE,$this->DB_USERNAME,$this->DB_PASSWORD);
		
	}
	//CREATE NEW ORDER
	public function new_order($clientlname,$clientfname,$clientemail,$clientphone,$clientaddress){
		
		/* Setting Timezone for DB */
		$NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$NOW = $NOW->format('Y-m-d H:i:s');

		$data = [
			[$clientlname,$clientfname,$clientemail,$clientphone,$clientaddress,'0',$NOW,$NOW],
		];
		$stmt = $this->conn->prepare("INSERT INTO tbl_orders (client_lastname, client_firstname, client_email, client_phone, client_address, order_status, order_date_added, order_time_added) VALUES (?,?,?,?,?,?,?,?)");
		try {
			$this->conn->beginTransaction();
			foreach ($data as $row)
			{
				$stmt->execute($row);
			}
			$id= $this->conn->lastInsertId();
			$this->conn->commit();
		}catch (Exception $e){
			$this->conn->rollback();
			throw $e;
		}

		return $id;

	}

	public function list_order(){
		$sql="SELECT * FROM tbl_orders";
		$q = $this->conn->query($sql) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
		}
		if(empty($data)){
		   return false;
		}else{
			return $data;	
		}
}

public function list_ongoing_orders(){
	$sql="SELECT * FROM tbl_orders WHERE order_status='0'";
	$q = $this->conn->query($sql) or die("failed!");
	while($r = $q->fetch(PDO::FETCH_ASSOC)){
	$data[]=$r;
	}
	if(empty($data)){
	   return false;
	}else{
		return $data;	
	}
}
public function list_orders_search($keyword){
		
	//$keyword = "%".$keyword."%";

	$q = $this->conn->prepare('SELECT * FROM `tbl_orders` WHERE `client_lastname` LIKE ?');
	$q->bindValue(1, "%$keyword%", PDO::PARAM_STR);
	$q->execute();

	while($r = $q->fetch(PDO::FETCH_ASSOC)){
	$data[]= $r;
	}
	if(empty($data)){
	   return false;
	}else{
		return $data;	
	}
}
// FUNCTIONS TO GET ORDER INFORMATION COLUMN DATAS FROM ORDER TABLE
	function get_order_id($clientlname){
		$sql="SELECT order_id FROM tbl_orders WHERE client_lastname = :clientlname";	
		$q = $this->conn->prepare($sql);
		$q->execute(['clientlname' => $clientlname]);
		$order_id = $q->fetchColumn();
		return $order_id;
	}
	function get_client_lastname($id){
		$sql="SELECT client_lastname FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$client_lastname = $q->fetchColumn();
		return $client_lastname;
	}
	function get_client_firstname($id){
		$sql="SELECT client_firstname FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$client_firstname = $q->fetchColumn();
		return $client_firstname;
	}
	function get_client_email($id){
		$sql="SELECT client_email FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$client_email = $q->fetchColumn();
		return $client_email;
	}
	function get_client_phone($id){
		$sql="SELECT client_phone FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$client_phone = $q->fetchColumn();
		return $client_phone;
	}
	function get_client_address($id){
		$sql="SELECT client_address FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$client_address = $q->fetchColumn();
		return $client_address;
	}
	function get_date_created($id){
		$sql="SELECT order_date_added FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$order_date_added = $q->fetchColumn();
		return $order_date_added;
	}
	function get_order_status($id){
		$sql="SELECT order_status FROM tbl_orders WHERE order_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$order_status = $q->fetchColumn();
		return $order_status;
	}
	//UPDATE/CHANGE ORDER INFORMATION FUNCTIONS
	public function update_client($clientemail,$clientphone,$clientaddress,$orderid){
		$NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$NOW = $NOW->format('Y-m-d H:i:s');

		$sql = "UPDATE tbl_orders SET client_email=:client_email,client_phone=:client_phone, client_address=:client_address, order_date_updated=:order_date_updated,order_time_updated=:order_time_updated WHERE order_id=:order_id";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':client_email'=>$clientemail,':client_phone'=>$clientphone, ':client_address'=>$clientaddress, ':order_date_updated'=>$NOW,':order_time_updated'=>$NOW,':order_id'=>$orderid));
		return true;
	}

	/* ORDER PRODUCT FUNTIONS (ADDING PRODUCT TO ORDERS) */
	public function new_order_product($orderid,$productid,$productqty,$amount,$notes){
		
		/* Setting Timezone for DB */
		$NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$NOW = $NOW->format('Y-m-d H:i:s');
		$uniqid = uniqid().'.'.$orderid;

		$data = [
			[$orderid,$productid,$productqty,$amount,$notes,$NOW,$uniqid],
		];
		$stmt = $this->conn->prepare("INSERT INTO tbl_order_products (order_id, product_id, product_qty, amount, notes, product_date_added, order_product_uniqid) VALUES (?,?,?,?,?,?,?)");
		try {
			$this->conn->beginTransaction();
			foreach ($data as $row)
			{
				$stmt->execute($row);
			}
			$this->conn->commit();
		}catch (Exception $e){
			$this->conn->rollback();
				throw $e;
		}

		return true;

	}

	

	public function list_order_products($id){
	$sql="SELECT * FROM tbl_order_products WHERE order_id=$id";
	$q = $this->conn->query($sql) or die("failed!");
	while($r = $q->fetch(PDO::FETCH_ASSOC)){
	$data[]=$r;
	}
	if(empty($data)){
	   return false;
	}else{
		return $data;	
	}
	}

	//FUNCTIONS TO GET ORDER PRODUCTS INFORMATION COLUMN DATAS FROM ORDER PRODUCTS TABLE
function get_order_product_id($prodid){
	$sql="SELECT order_id FROM tbl_order_products WHERE product_id = :prodid";	
	$q = $this->conn->prepare($sql);
	$q->execute(['prodid' => $prodid]);
	$product_order_id = $q->fetchColumn();
	return $product_order_id;
}
function get_product_id($id){
	$sql="SELECT product_id FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$product_id = $q->fetchColumn();
	return $product_id;
}
function get_product_qty($id){
	$sql="SELECT product_qty FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$product_qty = $q->fetchColumn();
	return $product_qty;
}
function get_order_amount($id){
	$sql="SELECT amount FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$amount = $q->fetchColumn();
	return $amount;
}
function get_order_notes($id){
	$sql="SELECT notes FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$notes = $q->fetchColumn();
	return $notes;
}

function get_product_sum($id){
	$sql="SELECT SUM(amount) FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$sum_amount = $q->fetchColumn();
	return $sum_amount;
}
function get_product_uniqid($id){
	$sql="SELECT order_product_uniqid FROM tbl_order_products WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$uniq_id = $q->fetchColumn();
	return $uniq_id;
}


public function upload_ref_image($orderid,$filename){
		

	$NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
	$NOW = $NOW->format('Y-m-d H:i:s');

	$data = [
		[$orderid, $filename],
	];
	$stmt = $this->conn->prepare("INSERT INTO tbl_order_images (order_id, file_name) VALUES (?,?)");
	try {
		$this->conn->beginTransaction();
		foreach ($data as $row)
		{
			$stmt->execute($row);
		}
		$this->conn->commit();
	}catch (Exception $e){
		$this->conn->rollback();
			throw $e;
	}

	return true;

}
public function list_imgs($id){
	$sql="SELECT * FROM tbl_order_images WHERE order_id =$id";
	$q = $this->conn->query($sql) or die("failed!");
	while($r = $q->fetch(PDO::FETCH_ASSOC)){
	$data[]=$r;
	}
	if(empty($data)){
	   return false;
	}else{
		return $data;	
	}
}
function get_img_id($id){
	$sql="SELECT image_id FROM tbl_order_images WHERE order_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$image_id = $q->fetchColumn();
	return $image_id;
}

function get_order_img($id){
	$sql="SELECT file_name FROM tbl_order_images WHERE image_id = :id";	
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	$order_img = $q->fetchColumn();
	return $order_img;
}
function remove_image($id){
	$sql = "DELETE FROM tbl_order_images WHERE image_id=:id";
	$q = $this->conn->prepare($sql);
	$q->execute(['id' => $id]);
	return true;
}
public function list_types(){
	$sql="SELECT * FROM tbl_type";
	$q = $this->conn->query($sql) or die("failed!");
	while($r = $q->fetch(PDO::FETCH_ASSOC)){
	$data[]=$r;
	}
	if(empty($data)){
	   return false;
	}else{
		return $data;	
	}
}

function remove_product($uniqid){
	$sql = "DELETE FROM tbl_order_products WHERE order_product_uniqid=:uniqid";
	$q = $this->conn->prepare($sql);
	$q->execute(['uniqid' => $uniqid]);
	return true;
}

public function delete_order($orderid){
	$sql = "DELETE tbl_orders, tbl_order_products FROM tbl_orders INNER JOIN tbl_order_products ON tbl_order_products.order_id = tbl_orders.order_id WHERE tbl_order_products.order_id =:orderid;"; //, tbl_order_products INNER JOIN tbl_order_products ON tbl_order_products.order_id = tbl_orders.order_id WHERE tbl_orders.order_id=:orderid"; 
	$q = $this->conn->prepare($sql);
	$q->execute(['orderid' => $orderid]);
	return true;
}

}

