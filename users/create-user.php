<h3>Enter User Information</h3>

<div id="form-block">

    <form onsubmit="return validateForm()" name="createuser" method="POST" action="processes/process.user.php?action=new">
      <div id="create-user-block">
        <div class="create-user-block2">

          <div class="create-user-sub">
            <div class="create-user-sub2">
              <label class="fname"for="firstname">First Name</label>
              <input type="text" id="fname" class="input" name="firstname" placeholder="Your name..">
            </div>

            <div class="create-user-sub2">
              <label class="lname"for="lastname">Last Name</label>
              <input type="text" id="lname" class="input" name="lastname" placeholder="Your last name..">
            </div>

          </div>

          <div class="create-user-sub">
            <div class="create-user-sub2">
              <label class="email"for="email">Email</label>
              <input type="email" id="email" class="input" name="email" placeholder="Your email..">
            </div>

            <div class="create-user-sub2">
              <label class="phone"for="phone">Mobile No.</label>
              <input type="tel" id="phone" class="input" name="phone" placeholder="contact no.">
            </div>

          </div>

          <div class="create-user-sub">
            <div class="create-user-sub2">
              <label class="password"for="password">Password <span>(Must include atleast one uppercase, lowercase, and numeric characters)</span></label>
              <input type="password" id="password" class="input" name="pass" placeholder="password">
            </div>

            <div class="create-user-sub2">
              <label class="password"for="confirmpassword">Confirm Password</label>
              <input type="password" id="password" class="input" name="confirmpass" placeholder="password">
            </div>

          </div>

          <div class="create-user-sub">
            <div class="create-user-sub2">
              <label class="access"for="access">Access</label>

              <select name="access">
                <option value="Staff">Staff</option>
                <option value="Manager">Manager</option>
                <option value="Supervisor">Supervisor</option>
              </select>

            </div>

            <div class="create-user-sub2">
              <button id="create-user-submit"type="submit">Add User</button>
            </div>

          </div>


        </div>
    </div>
  </form>
</div>
<script>
  function validateForm(){
     /*To check a password between 6 to 20 characters which contain at 
    least one numeric digit, one uppercase and one lowercase letter*/
    var passcheck = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/; 
   

    let fname = document.createuser.firstname.value;
    let lname = document.createuser.lastname.value;
    let email = document.createuser.email.value;
    let phone = document.createuser.phone.value;
    let passw = document.createuser.pass.value;
    let cpass = document.createuser.confirmpass.value;

    if(passw == "" || cpass =="" || fname =="" || lname =="" || email =="" || phone ==""){
      alert("Please fill out all fields!");
      return false;
    }else if(passw != cpass){
      alert("Password does not match!")
      return false;
    }else if(!passw.match(passcheck)){
      alert("Password is too weak!")
      return false;
    }else{
      return true;
    }
}
</script>
