<script>
var paymentForm="";
paymentForm += "  <div class=\"col-xs-12 col-md-12\">";
paymentForm += "            <!-- CREDIT CARD FORM STARTS HERE -->";
paymentForm += "            <div class=\"panel panel-default credit-card-box\">";
paymentForm += "                <div class=\"panel-heading display-table\" >";
paymentForm += "                    <div class=\"row display-tr\" >";
paymentForm += "                        <h3 class=\"panel-title display-td\" >Payment Details<\/h3>";
paymentForm += "                        <div class=\"display-td\" >                            ";
paymentForm += "                            <img class=\"img-responsive pull-right\" src=\"http:\/\/i76.imgup.net\/accepted_c22e0.png\">";
paymentForm += "                        <\/div>";
paymentForm += "                    <\/div>                    ";
paymentForm += "                <\/div>";
paymentForm += "                <div class=\"panel-body\">";
paymentForm += "                    <form role=\"form\" id=\"payment-form\" method=\"POST\" action=\"javascript:void(0);\">";
paymentForm += "                        <div class=\"row\">";
paymentForm += "                            <div class=\"col-xs-12\">";
paymentForm += "                                <div class=\"form-group\">";
paymentForm += "                                    <label for=\"cardNumber\">CARD NUMBER<\/label>";
paymentForm += "                                    <div class=\"input-group\">";
paymentForm += "                                        <input ";
paymentForm += "                                            type=\"tel\"";
paymentForm += "                                            class=\"form-control\"";
paymentForm += "                                            name=\"cardNumber\"";
paymentForm += "                                            placeholder=\"Valid Card Number\"";
paymentForm += "                                            autocomplete=\"cc-number\"";
paymentForm += "                                            required autofocus ";
paymentForm += "                                        \/>";
paymentForm += "                                        <span class=\"input-group-addon\"><i class=\"fa fa-credit-card\"><\/i><\/span>";
paymentForm += "                                    <\/div>";
paymentForm += "                                <\/div>                            ";
paymentForm += "                            <\/div>";
paymentForm += "                        <\/div>";
paymentForm += "                        <div class=\"row\">";
paymentForm += "                            <div class=\"col-xs-7 col-md-7\">";
paymentForm += "                                <div class=\"form-group\">";
paymentForm += "                                    <label for=\"cardExpiry\"><span class=\"hidden-xs\">EXPIRATION<\/span><span class=\"visible-xs-inline\">EXP<\/span> DATE<\/label>";
paymentForm += "                                    <input ";
paymentForm += "                                        type=\"tel\" ";
paymentForm += "                                        class=\"form-control\" ";
paymentForm += "                                        name=\"cardExpiry\"";
paymentForm += "                                        placeholder=\"MM \/ YY\"";
paymentForm += "                                        autocomplete=\"cc-exp\"";
paymentForm += "                                        required ";
paymentForm += "                                    \/>";
paymentForm += "                                <\/div>";
paymentForm += "                            <\/div>";
paymentForm += "                            <div class=\"col-xs-5 col-md-5 pull-right\">";
paymentForm += "                                <div class=\"form-group\">";
paymentForm += "                                    <label for=\"cardCVC\">CV CODE<\/label>";
paymentForm += "                                    <input ";
paymentForm += "                                        type=\"tel\" ";
paymentForm += "                                        class=\"form-control\"";
paymentForm += "                                        name=\"cardCVC\"";
paymentForm += "                                        placeholder=\"CVC\"";
paymentForm += "                                        autocomplete=\"cc-csc\"";
paymentForm += "                                        required";
paymentForm += "                                    \/>";
paymentForm += "                                <\/div>";
paymentForm += "                            <\/div>";
paymentForm += "                        <\/div>";
paymentForm += "                       ";
paymentForm += "                        <div class=\"row\">";
paymentForm += "                            <div class=\"col-xs-12\">";
paymentForm += "                                <button class=\"subscribe btn btn-success btn-lg btn-block\" type=\"button\">Start Subscription<\/button>";
paymentForm += "                            <\/div>";
paymentForm += "                        <\/div>";
paymentForm += "                        <div class=\"row\" style=\"display:none;\">";
paymentForm += "                            <div class=\"col-xs-12\">";
paymentForm += "                                <p class=\"payment-errors\"><\/p>";
paymentForm += "                            <\/div>";
paymentForm += "                        <\/div>";
paymentForm += "                    <\/form>";
paymentForm += "                <\/div>";
paymentForm += "            <\/div>            ";
paymentForm += "            <!-- CREDIT CARD FORM ENDS HERE -->";
paymentForm += "        <\/div>    ";


   jQuery(document).ready(function(){
	
		jQuery("#doPayment").click(function(e){
			//bootbox.alert({ message: paymentForm});
			jQuery("#paymentForm").modal('show');
			jQuery("#paymentForm .subscribe").text('Payment');
		});
	});


</script>


<div id="paymentForm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        
		<div class="col-xs-12 col-md-12">
            <!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                    <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
                                        <input 
                                            type="tel"
                                            class="form-control"
                                            name="cardNumber"
                                            placeholder="Valid Card Number"
                                            autocomplete="cc-number"
                                            required autofocus 
                                        />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        name="cardExpiry"
                                        placeholder="MM / YY"
                                        autocomplete="cc-exp"
                                        required 
                                    />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">CV CODE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control"
                                        name="cardCVC"
                                        placeholder="CVC"
                                        autocomplete="cc-csc"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="subscribe btn btn-success btn-lg btn-block" type="button">Payment</button>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            
            <!-- CREDIT CARD FORM ENDS HERE -->
        </div>    
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>