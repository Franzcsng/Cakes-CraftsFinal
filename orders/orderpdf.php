<?php
include_once '../classes/class.user.php';
include_once '../classes/order.class.php';
include '../config/config.php';
require('../fpdf/fpdf.php');

$order = new Order();
/*
$user = new User();
$user_id_login = $user->get_user_id($_SESSION['user_email']);
$user_access_level = $user->get_user_access($user_id_login);
*/
class PDF extends FPDF
{
//Page header
function Header(){
	 
	//Arial 12
	$this->SetFont('Arial','',12);
	//Background color
	$this->SetFillColor(200,220,255);
	//Title
	$this->Cell(0,6,"Order Report",0,1,'L',1);
	$this->SetFont('Arial','BIU',10);
	$this->Cell(0,6,"Date Generated ".date("Y-m-d h:i:s A")." ",0,1,'L',1);
	$this->SetFont('Arial','',12);
    
   
    //Line break
    $this->Ln(4);
}
function BasicTable($header){
    //Header
    foreach($header as $col)
        $this->Cell(47,7,$col,0,0,'C');
	$this->Ln();
}
//Page footer
function Footer(){
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
// Default Header
//$header=array('Nbr','Name','Access Level','E-Mail');
//$pdf->BasicTable($header);
// Custom Header
$pdf->Cell(5,12,"#",1,0,'C');
$pdf->Cell(23,12,"ID",1,0,'C');
$pdf->Cell(30,12,"Client",1,0,'C');
$pdf->Cell(35,12,"Contact",1,0,'C');
$pdf->Cell(40,12,"E-Mail",1,0,'C');
$pdf->Cell(30,12,"Date Created",1,0,'C');
$pdf->Cell(30,12,"Status",1,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$count = 1;
$status = "";
if($order->list_order() != false){
    foreach($order->list_order() as $value){
        extract($value);     
        if($order_status == "0"){
            $status = "On Going";
        }else{
            $status = "Completed";
        }
                $pdf->Cell(5,12,$count,0,0,'L');
                $pdf->Cell(23,12,$order_id,0,0,'L');
                $pdf->Cell(30,12,$client_firstname.', '.$client_lastname,0,0,'L');
                $pdf->Cell(35,12,$client_phone,0,0,'L');
                $pdf->Cell(40,12,$client_email,0,0,'L');
                $pdf->Cell(30,12,$order_date_added,0,0,'L');
                $pdf->Cell(30,12,$status,0,0,'L');
                $pdf->Ln(6);
                $count++;
    }
}	

$pdf->SetFont('Arial','I',12);
$pdf->Cell(176,12,"--Nothing Follows--",0,0,'C');
$pdf->Output();
?>