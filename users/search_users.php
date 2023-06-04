<?php
include_once '../classes/class.user.php';
//include_once '../classes/class.inventory.php';
//include '../config/config.php';
$user = new User();
//$inventory = new Inventory();

// get the q parameter from URL
$q = $_GET["q"];
$count = 1;
$hint='
    <table id="user-list">
      <tr>
        <th class="id">#</th>
        <th class="name">Name</th>
        <th class="email">Email</th>
        <th class="phone">Phone</th>
        <th class="status">Status</th>
        <th class="access">Access</th>
      </tr>';
$data = $user->list_users_search($q);
if($data != false){
    //$hint = '<ul>';
    foreach($data as $value){
        extract($value);
        $status = "";
        $link = "";
        if($user_status == '0'){
            $status = "Active";

        }else{
            $status = "Disabled";
        }
        //$hint .= '<li>'.$prod_name. '</li>';
        $hint .= '
        <tr>
            <td class="center">'.$count.'</td>
            <td><a href="index.php?page=settings&subpage=profile&id='.$user_id.'">'.$user_lastname.', '.$user_firstname.'</a></td>
            <td class="center">'.$user_email.'</td>
            <td class="center">'.$user_phone.'</td>
            <td class="center">'.$status.'</td>
            <td class="center">'.$user_access.'</td>
        </tr>';
        $count++;
    }
}
$hint .= '</table>
';

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "No result(s)" : $hint;
?>