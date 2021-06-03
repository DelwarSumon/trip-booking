<div class="user_main_div">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			<div class="nv_trip_detail">
				
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
				<div class="rows p2_2">
					<form action="<?php echo $n_lt_plUrl."?page=book-trip&trip=".$trips->id; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="page" value="book-trip">
						<input type="hidden" name="trip" value="<?php echo $trips->id; ?>">
						
						<div class="col-md-8 col-sm-6 col-xs-12 p2_1 text-left">
							<h1><?php echo $trips->Trip_Name; ?></h1>

							<div class="clr h10"></div>
							<div>
								<!-- <div class="band">
									<img src="http://rn53themes.net/themes/demo/travelz/images/band.png" alt="" /> 
								</div>  -->
								<img class="trip_img" src="<?php echo $trips->Trip_Image_Url; ?>" alt="" /> 
							</div>
							<div class="clr h20"></div>
							<h3><span style="font-size: 15px;">From USD</span><br>$<?php echo $trips->Trip_Total_Price; ?></h3>

							<?php 
							$startTimeStamp = strtotime($trips->Trip_Start_Date);
							$endTimeStamp = strtotime($trips->Trip_End_Date);
							$timeDiff = abs($endTimeStamp - $startTimeStamp);
							$numberDays = $timeDiff/86400;  // 86400 seconds in one day
							// and you might want to convert to integer
							$numberDays = intval($numberDays);
							?>
							<p><strong>Duration:</strong> <?php echo $numberDays; ?> Days (approx.)</p>
							<div class="clr h10"></div>
							<p class="trip_desc"><?php echo $trips->Trip_Description; ?></p>
							<div class="clr h10"></div>


						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 p2 right-side text-left" >
							
							<h4 class="blackHeader">Start Booking Now</h4>
							<div class="clr "></div>
							
							<div class="right-side-box">
								<div class="clr "></div>
								
								<div class="form-group">
									<label>Select Date</label>
									<select name="tp" id="tp_follow" class="form-control" required="">
										<option value="1"><?php echo date("F d -", strtotime($trips->Trip_Start_Date)).date("F d", strtotime($trips->Trip_End_Date))." - Available"; ?></option>
										<?php if(($trips->Trip_2_Start_Date != "") && ($trips->Trip_2_End_Date != "")){ ?>
										<option value="2"><?php echo date("F d -", strtotime($trips->Trip_2_Start_Date)).date("F d", strtotime($trips->Trip_2_End_Date))." - Available"; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="clr "></div>

								<div class="form-group ">
									<label for="" class="col-form-label">Total Guests<sup>*</sup></label>
									<input type="number"  class="form-control" name="Total_Guest_Number" id="nv_tg_num" value="1" required="required">
								</div>
								<div class="clr"></div>

								<div class="form-group col-md-6 pdl-0">
									<label for="" class="col-form-label">Male<sup>*</sup></label>
									<input type="number"  class="form-control" name="Total_Male" value="1" required="required">
								</div>

								<div class="form-group col-md-6 pdr-0">
									<label for="" class="col-form-label">Female<sup>*</sup></label>
									<input type="number"  class="form-control" name="Total_Female" value="0" required="required">
								</div>
								<div class="clr"></div>

								<div class="form-group ">
									<label>Select Payment</label>
									<select name="Payment_Option" id="nv_P_Option" class="nv_P_Option form-control" >
										<option value="1"><?php echo "$".number_format($trips->Trip_Deposit_Amount)." Deposit"; ?></option>
										<option value="2"><?php echo "$".number_format($trips->Trip_Total_Price)." Pay in Full"; ?></option>
										<option value="3"><?php echo "$".number_format($trips->Trip_Single_Room_Price)." Deposit Single Room"; ?></option>
										<option value="4"><?php echo "$".number_format($trips->Trip_Single_Room_Total_Price)." Pay in Full Single Room (+$".$trips->Trip_Single_Room_Price.")"; ?></option>
									</select>

									<select name="Payment_Option_2" id="nv_P_Option_2" class="nv_P_Option form-control" style="display: none;">
										<option value="1"><?php echo "$".number_format($trips->Trip_2_Deposit_Amount)." Deposit"; ?></option>
										<option value="2"><?php echo "$".number_format($trips->Trip_2_Total_Price)." Pay in Full"; ?></option>
										<option value="3"><?php echo "$".number_format($trips->Trip_2_Single_Room_Price)." Deposit Single Room"; ?></option>
										<option value="4"><?php echo "$".number_format($trips->Trip_2_Single_Room_Total_Price)." Pay in Full Single Room (+$600)"; ?></option>
									</select>
								</div>
								<div class="clr"></div>

								<div class="form-group ">
									<label class="font-weight-bold"><span class="float-left mr-2">Total (USD)</span><span class="nv_t_prc float-right">$<?php echo number_format($trips->Trip_Deposit_Amount,2); ?></span></label>
								</div>
								<div class="clr h10"></div>

								<div class="form-group ">
									<label for="" class="col-form-label">Notes</label>
									<textarea class="form-control" rows="3" name="Booking_Notes"></textarea>
								</div>
								<div class="clr"></div>


								<div class="clr h20"></div>

								<div class="p2_book">
									<input type="submit" class="btn-nv-trip btn-block" value="Book Now">
								</div>
								<div class="clr h20"></div>
								<p class="short-note"><strong>Please note:</strong> This product is on request. We will confirm availability within the shortest possible time after we receive your order.</p>
								<div class="clr "></div>
							</div>
						</div>

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
		<div class="col-sm-12"  style="text-align: center;">
		    <h3><strong>Life Begins</strong> at the <strong>End</strong> of Your <strong>Comfort Zone</strong></h3>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$(".user_main_div").parent().find("h3:first").html("");

		$(document).on("change","#tp_follow",function(){
			var tp_follow = $(this).val();
			if(tp_follow == "1"){
				$("#nv_P_Option").show();
				$("#nv_P_Option_2").hide();
			}else if(tp_follow == "2"){
				$("#nv_P_Option").hide();
				$("#nv_P_Option_2").show();
			}

			calculate_tp();

		});

		$(document).on("change",".nv_P_Option",function(){

			var tp_follow = $("#tp_follow").val();
			var p_Option = $(this).val();
			var tg_num = parseInt($('#nv_tg_num').val());
			if(isNaN(tg_num) || (tg_num == 0)) {
				tg_num = 1;
			}
			var trip_total = 0;
			if(tp_follow == "2"){

				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}else{
				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
					// $('#nv_t_prc_val').val("<?php //echo $trips->Trip_Total_Price; ?>");
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}

			$('.nv_t_prc').text("$"+trip_total.toLocaleString(undefined, {minimumFractionDigits: 2}));
			// $('#nv_t_prc_val').val(trip_total);
		});

		$(document).on("blur","#nv_tg_num",function(){

			var tp_follow = $("#tp_follow").val();
			if(tp_follow == "2"){
				var p_Option = $("#nv_P_Option_2").val();
			}else{
				var p_Option = $("#nv_P_Option").val();
			}
			var tg_num = parseInt($(this).val());
			if(isNaN(tg_num) || (tg_num == 0)) {
				tg_num = 1;
			}

			var trip_total = 0;
			if(tp_follow == "2"){

				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}else{
				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
					// $('#nv_t_prc_val').val("<?php //echo $trips->Trip_Total_Price; ?>");
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}
			
			$('.nv_t_prc').text("$"+trip_total.toLocaleString(undefined, {minimumFractionDigits: 2}));
			// $('#nv_t_prc_val').val(trip_total);
		});



		function calculate_tp(){
			var tp_follow = $("#tp_follow").val();
			if(tp_follow == "2"){
				var p_Option = $("#nv_P_Option_2").val();
			}else{
				var p_Option = $("#nv_P_Option").val();
			}
			var tg_num = parseInt($('#nv_tg_num').val());
			if(isNaN(tg_num) || (tg_num == 0)) {
				tg_num = 1;
			}
			var trip_total = 0;
			if(tp_follow == "2"){

				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_2_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}else{
				if(p_Option == "1"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Deposit_Amount; ?>");
					trip_total = (trip_amount * tg_num);
					
				}else if(p_Option == "2"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
					// $('#nv_t_prc_val').val("<?php //echo $trips->Trip_Total_Price; ?>");
				}else if(p_Option == "3"){
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}else{
					var trip_amount = parseInt("<?php echo $trips->Trip_Single_Room_Total_Price; ?>");
					trip_total = (trip_amount * tg_num);
				}
			}

			$('.nv_t_prc').text("$"+trip_total.toLocaleString(undefined, {minimumFractionDigits: 2}));
		}


	});



</script>