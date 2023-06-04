<h3>Enter Courier Information</h3>

<div id="form-block-courier">

    <form name="createcourier" onsubmit="return validateCreateCourier()" method="POST" action="processes/process.courier.php?action=new">

        <div id="form-block-half-courier">
          <div class ="block1" id="block1-bottom">

            <div class="sub-block">
              <label class="lblcourier"for="couriername">Courier Name</label>
              <input type="text" id="couriername" class="input" name="couriername" placeholder="courier name..">
            </div>

            <div class="sub-block">
              <label class="lblcontact"for="contact">Contact</label>
              <input type="tel" id="contact" class="input" name="couriercontact" placeholder="courier contact..">
            </div>
      
          </div>

          <div id="button-block">
            <input type="submit" value="Add New Courier">
          </div>

        </div>   
        
    </form>

</div>
<script>
  function validateCreateCourier(){
   
    let name = document.createcourier.couriername.value;
    let contact = document.createcourier.couriercontact.value;

    if(name == "" || contact ==""){
      alert("Please fill out all fields!");
      return false;
    }else{
      return true;
    }
}
</script>