<div class="user_main_div">
<style type="text/css">
	.StripeElement {
	  box-sizing: border-box;

	  height: 40px;

	  padding: 10px 12px;

	  border: 1px solid transparent;
	  border-radius: 4px;
	  background-color: white;

	  box-shadow: 0 1px 3px 0 #e6ebf1;
	  -webkit-transition: box-shadow 150ms ease;
	  transition: box-shadow 150ms ease;
	  width: 100%;
	}

	.StripeElement--focus {
	  box-shadow: 0 1px 3px 0 #cfd7df;
	}

	.StripeElement--invalid {
	  border-color: #fa755a;
	}

	.StripeElement--webkit-autofill {
	  background-color: #fefde5 !important;
	}
</style>


	<div class="row">
		<div class="col-md-12">
			
			<div class="nv_trip_book">
				
				<?php if(!empty($_SESSION['status'])){ $status = ($_SESSION['status'] == 'success') ? 'success' : 'danger'; ?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-<?php echo $status ?>"><?php echo $_SESSION['msg']; ?></div>
						</div>
					</div>
					<div class="clr" style="height: 20px;"></div>
				<?php 
				unset($_SESSION['status']);
				unset($_SESSION['msg']);
				} 

				if(isset($trips)){ 
				?>
				<div class="rows p2_2 ">
					<form action="<?php echo $n_lt_plUrl."?page=checkout&trip=".$_GET['trip']; ?>" method="post" enctype="multipart/form-data" id="payment-form">
						<input type="hidden" name="trip_id" value="<?php echo $trips->id; ?>">
						<input type="hidden" name="tp" value="<?php echo $post_data['tp']; ?>">
						
						<input type="hidden"  class="form-control" name="Total_Guest_Number" value="<?php echo $post_data['Total_Guest_Number']; ?>">
						<input type="hidden"  class="form-control" name="Total_Male" value="<?php echo $post_data['Total_Male']; ?>">
						<input type="hidden"  class="form-control" name="Total_Female" value="<?php echo $post_data['Total_Female']; ?>">
						<input type="hidden"  class="form-control" name="Payment_Option" id="nv_P_Option" value="<?php echo $post_data['Payment_Option']; ?>">
						<input type="hidden"  class="form-control" name="Booking_Notes" value="<?php echo $post_data['Booking_Notes']; ?>">

						<div class="col-md-6 col-sm-12 col-xs-12 p2 pdl-0" style="border: 1px solid gray;border-radius: 5px;padding: 10px;">
							<h2 class="col-md-12 border-bottom ">Guest 1 Information</h2>
							<div class="clr h20"></div>
							
							<!-- <div class="form-group col-md-12">
								<label>Choose Payment</label>
								<select name="Payment_Option" id="nv_P_Option" class="form-control" required="">
									<option value="1">$<?php //echo $trips->Trip_Deposit_Amount; ?> Deposit</option>
									<option value="2">$<?php //echo $trips->Trip_Total_Price; ?> Pay in Full</option>
									<option value="3">$<?php //echo $trips->Trip_Single_Room_Price; ?> Deposit Single Room</option>
									<option value="4">$<?php //echo $trips->Trip_Single_Room_Total_Price; ?> Pay in Full Single Room</option>
								</select>
							</div>
							<div class="clr"></div> -->

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">First Name<sup>*</sup></label>
								<input type="text"  class="form-control" name="First_Name" value="" required="required">
							</div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">Last Name<sup>*</sup></label>
								<input type="text"  class="form-control" name="Last_Name" value="" required="required">
							</div>

							<div class="clr"></div>
							<!-- <div class="form-group col-md-12"> -->
								<!-- <label for="" class="col-form-label">Company name</label> -->
								<input type="hidden"  class="form-control" name="Company_Name" value="" >
							<!-- </div> -->
							<!-- <div class="clr"></div> -->

							<!-- <div class="form-group col-md-6">
								<label for="" class="col-form-label">Total Guest Number<sup>*</sup></label>
								<input type="number"  class="form-control" name="Total_Guest_Number" id="nv_tg_num" value="1" required="required">
							</div>
							<div class="clr"></div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">Male<sup>*</sup></label>
								<input type="number"  class="form-control" name="Total_Male" value="1" required="required">
							</div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">Female<sup>*</sup></label>
								<input type="number"  class="form-control" name="Total_Female" value="0" required="required">
							</div>
							<div class="clr"></div> -->

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Street Address<sup>*</sup></label>
								<input type="text"  class="form-control" name="Mailing_Street" value="" required="required">
							</div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">City / Town<sup>*</sup></label>
								<input type="text"  class="form-control" name="Mailing_City" value="" required="required">
							</div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">State<sup>*</sup></label>
								<input type="text"  class="form-control" name="Mailing_State" value="" required="required">
							</div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">Postcode / Zip<sup>*</sup></label>
								<input type="text"  class="form-control" name="Mailing_Zip" value="" required="required">
							</div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Country<sup>*</sup></label>
								<input type="text"  class="form-control" name="Mailing_Country" value="" required="required">
							</div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Mobile #<sup>*</sup></label>
								<input type="text"  class="form-control" name="Phone" value="" required="required">
							</div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Email<sup>*</sup></label>
								<input type="email"  class="form-control" name="Email" value="" required="required">
							</div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Gender<sup>*</sup></label>
								<select class="form-control" name="Gender" required="">
									<option value="">--None--</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<div class="clr"></div>

							<?php if($post_data['Total_Guest_Number'] > 1){ 
								for($i=1; $i < $post_data['Total_Guest_Number']; $i++){
							?>
							
							<div class="clr h20"></div>
							<h2 class="col-md-12 border-bottom "><?php echo "Guest ".($i+1)." Information"; ?></h2>
							<div class="clr h20"></div>
							

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">First Name<sup>*</sup></label>
								<input type="text"  class="form-control" name="Guest_First_Name[]" value="" required="required">
							</div>

							<div class="form-group col-md-6">
								<label for="" class="col-form-label">Last Name<sup>*</sup></label>
								<input type="text"  class="form-control" name="Guest_Last_Name[]" value="" required="required">
							</div>
							<div class="clr"></div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Gender<sup>*</sup></label>
								<select class="form-control" name="Guest_Gender[]" required="">
									<option value="">--None--</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<div class="clr"></div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Mobile #<sup>*</sup></label>
								<input type="text"  class="form-control" name="Guest_Phone[]" value="" required="required">
							</div>
							<div class="clr"></div>

							<div class="form-group col-md-12">
								<label for="" class="col-form-label">Email<sup>*</sup></label>
								<input type="email"  class="form-control" name="Guest_Email[]" value="" required="required">
							</div>
							<div class="clr"></div>

							<?php } } ?>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p2 ">
							
							<h4 style="margin: 0; margin-bottom: 10px;">Payment</h4>
							<div class="clr"></div>
							<input type="hidden" name="nv_t_prc" id="nv_t_prc_val" value="<?php echo $pay_amount; ?>">
							<div class="lt_ck_item_tbl table-responsive">
								<table style="width: 100%;">
									<tbody>
										<tr>
											<td>
												<img src="<?php echo $trips->Trip_Image_Url; ?>" style="width:100px; height: 100px;float: left;margin-right: 10px;">

												<?php echo $trips->Trip_Name."<br>";
												if($post_data['tp'] == "1"){
													echo date("F d, Y", strtotime($trips->Trip_Start_Date))." - ".date("F d, Y", strtotime($trips->Trip_End_Date)); 
												}else{
													echo date("F d, Y", strtotime($trips->Trip_2_Start_Date))." - ".date("F d, Y", strtotime($trips->Trip_2_End_Date)); 
												}
												?></td>
											<td class="nv_t_prc text-right">$<?php echo number_format($pay_amount,2); ?></td>
										</tr>
										<tr>
											<td class="text-right">Subtotal</td>
											<td class="nv_t_prc text-right">$<?php echo number_format($pay_amount,2); ?></td>
										</tr>
										<tr>
											<td class="text-right"><strong>Total</strong></td>
											<td class="bold nv_t_prc text-right">$<?php echo number_format($pay_amount,2); ?></td>
										</tr>
									</tbody>
								</table>
							</div> <!-- lt_ck_item_tbl end -->


							<div class="clr" style="height: 20px;"></div>
							<div class="form-group ">
								<label for="" class="col-form-label">Promo Code</label>
								<input type="text"  class="form-control" name="Trip_Promo_Code" value="">
							</div>

							<div class="clr" style="height: 20px;"></div>
							<div class="lt_ck_cc_div">
								<!-- <p>Credit card (Stripe)</p> -->
								<div class="clr"></div>

								<div class="lt_ck_cc_take" >
									<script src="https://js.stripe.com/v3/"></script>
								  	<div class="form-row">
									    <label for="card-element">
									      	Credit or Debit Card
									    </label>
								    	<div id="card-element">
								      		<!-- A Stripe Element will be inserted here. -->
								    	</div>
								    	<!-- Used to display form errors. -->
								    	<div id="card-errors" role="alert"></div>
								  	</div>
									<div class="clr"></div>
								</div>
								<div class="clr"></div>
							</div><!--  lt_ck_cc_div end -->

							<div class="clr h20"></div>
							<div class="form-group ">
								<input type="submit" name="lt_ck_pay_ord" class="btn-nv-trip" value="Place order" />
							</div>
							<div class="clr "></div>

						</div>
						<div class="clr h20"></div>

						

					</form>
				</div>


				<?php }else{
					echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
				} ?>
			</div>
		</div>


	</div>

	<div style="clear: both; height: 30px; width: 100%;"></div>
	<div class="row">
		<div class="col-sm-12" style="text-align: center;">
		    <h3>The Only Trip You Regret is <strong>the One You Didn’t Take</strong></h3>
		</div>
	</div>

	<!-- <input type="hidden" id="apikey" value="<?php //echo $Stripe->Api_key; ?>"> -->
	<script type="text/javascript">
		$(document).ready(function(){
			$(".user_main_div").parent().find("h3:first").html("");
			
			$(document).on("change","#nv_P_Option",function(){

				var p_Option = $(this).val();
				var tg_num = parseInt($('#nv_tg_num').val());
				if(isNaN(tg_num) || (tg_num == 0)) {
					tg_num = 1;
				}
				var trip_total = 0;
				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
					$('.nv_t_prc').text("$<?php echo $trips->Trip_Total_Price; ?>");
					$('#nv_t_prc_val').val("<?php echo $trips->Trip_Total_Price; ?>");
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}

				$('.nv_t_prc').text("$"+trip_total);
				$('#nv_t_prc_val').val(trip_total);
			});

			$(document).on("blur","#nv_tg_num",function(){

				var p_Option = $("#nv_P_Option").val();
				var tg_num = parseInt($(this).val());
				if(isNaN(tg_num) || (tg_num == 0)) {
					tg_num = 1;
				}

				var trip_total = 0;
				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
					$('.nv_t_prc').text("$<?php echo $trips->Trip_Total_Price; ?>");
					$('#nv_t_prc_val').val("<?php echo $trips->Trip_Total_Price; ?>");
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
				
				$('.nv_t_prc').text("$"+trip_total);
				$('#nv_t_prc_val').val(trip_total);
			});


		});
	</script>



	<script type="text/javascript">
		// Create a Stripe client.
		// apikey = jQuery("#apikey").val();
		//console.log(apikey);

		var stripe = Stripe('pk_test_4XNsn0yeZBG4FxmtVSeTGQoQ');
		// var stripe = Stripe(apikey);
		// Create an instance of Elements.
		var elements = stripe.elements();
		// Custom styling can be passed to options when creating an Element.
		// (Note that this demo uses a wider set of styles than the guide below.)
		var style = {
		  	base: {
			    color: '#32325d',
			    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
			    fontSmoothing: 'antialiased',
			    fontSize: '16px',
			    '::placeholder': {
			      	color: '#aab7c4'
			    }
		  	},
		  	invalid: {
			    color: '#fa755a',
			    iconColor: '#fa755a'
		  	}
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {hidePostalCode: true,style: style});

		// Add an instance of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		// Handle real-time validation errors from the card Element.
		card.addEventListener('change', function(event) {
		  	var displayError = document.getElementById('card-errors');
		  	if (event.error) {
		    	displayError.textContent = event.error.message;
		  	} else {
		    	displayError.textContent = '';
		  	}
		});

		// Handle form submission.
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  	event.preventDefault();
		  	stripe.createToken(card).then(function(result) {
			    if (result.error) {
			      	// Inform the user if there was an error.
			      	var errorElement = document.getElementById('card-errors');
			      	errorElement.textContent = result.error.message;
			    } else {
			      	// Send the token to your server.
			      	stripeTokenHandler(result.token);
			    }
		  	});

		});

		// Submit the form with the token ID.
		function stripeTokenHandler(token) {
			// Insert the token ID into the form so it gets submitted to the server
			var form = document.getElementById('payment-form');
			var hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', token.id);
			form.appendChild(hiddenInput);
			// Submit the form
			form.submit();
		}
	</script>




</div>



