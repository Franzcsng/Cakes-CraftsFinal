<script>
function showResults(str) {
  if (str.length == 0) {
    document.getElementById("search-result").innerHTML ="";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("search-result").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "users/search_users.php?q=" + str, true);
    xmlhttp.send();
  }
}
</script>
<?php
include_once 'classes/class.user.php';

/* instantiate class object */
$user = new User();

?>
<div class="content-main">


    <div class="subclass-nav">
        <a href="index.php?page=settings">users</a>

        <?php if($user->get_user_access($user_id) === "Supervisor"){ ?>
        <a href="index.php?page=settings&subpage=adduser">add user</a>
        <?php }else{}?>
        
        <div class="subnav-logout"><a class="logout" href="logout.php">log-out</a></div>
    </div>

    <div class="content-main2">
        <?php
                switch($subpage){
                case 'prodprofile':
                    require_once 'products/view-products.php';
                break; 
                case 'adduser':
                    require_once 'users/create-user.php';
                break; 
                case 'users':
                    require_once 'users/view-users.php';
                break; 
                case 'profile':
                    require_once 'users/view-profile.php';
                break; 
                default:
                    require_once 'users/view-users.php';
                break; 
                

            }
        ?>
    </div>
</div>