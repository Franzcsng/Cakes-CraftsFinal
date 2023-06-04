<h3>Provide Order Information</h3>

<div id="fb-order">
    <form method="POST" onsubmit="return validateCreateOrder()" name="createorder" action="processes/process.order.php?action=add">
        <div id="fb-order-center">

            <div class="block1">
              <div class="sub-block">
                <label class="lblorderclient "for="clientfname">First Name</label>
                <input type="text" id="clientfname" name="clientfname" placeholder="Client's First Name..">
              </div>
              
              <div class="sub-block">
                <label class="lblorderproduct" for="clientlname">Last Name</label>
                <input type="text" id="clientlname" name="clientlname" placeholder="Client's Last Name..">
              </div>
            </div>
              
              
            <div class="block1">

              <div class="sub-block">
                <label class="lblorderamount" for="clientphone">Client's Contact No.</label>
                <input type="number" id="clientphone" name="clientphone" placeholder="Client's Mobile..">
              </div>

              <div class="sub-block">
                <label class="lblreceivedby" for="clientemail">Client's Email</label>
                <input type="email" id="clientphone" name="clientemail" placeholder="client@mail.com">
              </div>
              
            </div>

            <div class="block1" id="block2-bottom">
              <div class="sub-block">
                <label class="lblreceivedby" for="clientadd ">Client's Address</label>
                <textarea rows="4" id="clientadd" name="clientaddress" placeholder="City, Street, House/Lot"></textarea>  
              </div>
            </div>

            <div id="button-block">
              <input id="addOrder"type="submit" value="Save Order">
            </div>

        </div>

       
    </form>
</div>
<script>
  function validateCreateOrder(){
   
    let fname = document.createorder.clientfname.value;
    let lname = document.createorder.clientlname.value;
    let cphone = document.createorder.clientphone.value;
    let email = document.createorder.clientemail.value;
    let cadd = document.createorder.clientaddress.value;


    if(fname == "" || lname == "" || email == "" || cadd == ""){
      alert("Please fill out all fields!");
      return false;
    }else{
      return true;
    }
}
</script>
