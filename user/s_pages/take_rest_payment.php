<div class="user_main_div" >
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

	<?php 
	$pay_amount = $booking->Trip_Total_Amount;
	?>
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

				if(isset($booking)){ 
				?>
				<div class="rows p2_2 ">
					<form action="<?php echo $n_lt_plUrl."?page=stake&booking=".$_GET['booking']; ?>" method="post" enctype="multipart/form-data" id="payment-form">
						
						<input type="hidden" name="booked_id" value="<?php echo $booking->crm_id; ?>">
						
						<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 p2 ">
							
							<!-- <h4 style="margin: 0; margin-bottom: 10px;">Your Trip</h4> -->
							<div class="clr"></div>
							
							<div class="lt_ck_item_tbl table-responsive">
								<table style="width: 100%;">
									<tbody>
										<tr>
											<td>
												<img src="<?php echo $trips->Trip_Image_Url; ?>" style="width:100px; height: 100px;float: left;margin-right: 10px;">

												<?php echo $booking->Trip_Name."<br>";
													echo date("F d, Y", strtotime($booking->Trip_Start_Date))." - ".date("F d, Y", strtotime($booking->Trip_End_Date)); 
												
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
										<tr>
											<td class="text-right"><strong>Amount Paid</strong></td>
											<td class="bold nv_t_prc text-right">$<?php echo number_format($booking->Trip_Paid_Amount,2); ?></td>
										</tr>
										<tr>
											<td class="text-right text-red"><strong>Amount Due</strong></td>
											<td class="bold nv_t_prc text-right text-red">$<?php echo number_format($booking->Trip_Due_Amount,2); ?></td>
										</tr>
										<tr>
											<td class="text-right text-red"><strong>Payment Amount</strong></td>
											<td class=" text-right"><input type="text"  class="text-right" name="take_amount" id="take_amount" value="<?php echo $booking->Trip_Due_Amount; ?>" ></td>
										</tr>
									</tbody>
								</table>
							</div> <!-- lt_ck_item_tbl end -->

							<div class="clr" style="height: 20px;"></div>

							<!-- <div class="form-group ">
								<label for="" class="col-form-label float-left">Payment Amount <sup>*</sup></label>
								<input type="text"  class="form-control" name="take_amount" id="take_amount" value="<?php //echo $booking->Trip_Due_Amount; ?>" >
							</div>
							<div class="clr h10"></div> -->

							<div class="lt_ck_cc_div">
								<!-- <p>Credit card (Stripe)</p> -->
								<div class="clr"></div>

								<div class="lt_ck_cc_take" >
									<script src="https://js.stripe.com/v3/"></script>
								  	<div class="form-row">
									    <label for="card-element">
									      	Credit or debit card
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
								<input type="submit" name="lt_ck_pay_ord" class="btn-nv-trip" value="Make Payment" />
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

	<!-- <input type="hidden" id="apikey" value="<?php //echo $Stripe->Api_key; ?>"> -->
	
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

			var take_amount = jQuery("#take_amount").val();
			console.log(take_amount);
			if((take_amount == "") || isNaN(take_amount) || (take_amount <= 0)){
				alert("Amount should be number & greater than zero.");
			}else{

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
		}
	</script>




</div>