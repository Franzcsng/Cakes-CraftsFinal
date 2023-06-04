
<div class="page-top-nav">
    <label id="nav-search" for="nav-search">Search</label>
    <input type="text" id="nav-search-input" name="nav-search" onkeyup="showResults(this.value)">
  </div>
  
  <div class="table-users" id="search-result">
    <table id="user-list">
      <tr>
        <th class="id">#</th>
        <th class="name">Name</th>
        <th class="email">Email</th>
        <th class="phone">Phone</th>
        <th class="status">Status</th>
        <th class="access">Access</th>
      </tr>
<?php
if($user->get_user_access($user_id) != "Supervisor"){
  $count = 1;
if($user->list_user($user_id) != false){
foreach($user->list_user($user_id) as $value){
   extract($value);
?>
      <tr>
        <td class="center"><?php echo $count;?></td>
        <td><a href="index.php?page=settings&subpage=profile&id=<?php echo $user_id;?>"><?php echo $user_lastname.', '.$user_firstname;?></a></td>
        <td class="center"><?php echo $user_email;?></td>
        <td class="center"><?php echo $user_phone;?></td>
        <td class="center"><?php if($user_status == "0"){echo "Active";}else{echo "Disabled";};?></td>
        <td class="center"><?php echo $user_access;?></td>
      </tr>
    
<?php
 }
 $count++;
}else{?>
  <h4 id="no-record-notif">NO RECORD FOUND </h4>
 <?php }
}else{
  $count = 1;
  if($user->list_all_users() != false){
    foreach($user->list_all_users() as $value){
       extract($value);
    ?>
          <tr>
            <td class="center"><?php echo $count;?></td>
            <td><a href="index.php?page=settings&subpage=profile&id=<?php echo $user_id;?>"><?php echo $user_lastname.', '.$user_firstname;?></a></td>
            <td class="center"><?php echo $user_email;?></td>
            <td class="center"><?php echo $user_phone;?></td>
            <td class="center"><?php if($user_status == "0"){echo "Active";}else{echo "Disabled";};?></td>
            <td class="center"><?php echo $user_access;?></td>
          </tr>
        
    <?php
     }
     $count++;
    }else{?>
      <h4 id="no-record-notif">NO RECORD FOUND </h4>
     <?php }
}
 
 ?>
    </table>
  </div>
