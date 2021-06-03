<div class="user_main_div">

	<div class="row">
		<div class="col-md-12">
			
			<div class="lt_lottery_div">
				
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

				// echo "<pre>"; print_r($trips);
				if(isset($trips)){
					foreach ($trips as $key => $value) {
				?>

				<div class="col-md-4">
					<div class="nv_trips">
						<div class="tourpic">
		                    <img src="<?php echo $value->Trip_Image_Url; ?>">
		                </div>
						<div class="clr" ></div>
						<div class="trip_dash_box col-md-12">
							<div class="clr h10" ></div>
							<h5 class="entry-title">
					            <a class="font-title" href="<?php echo $lt_pl_dtlUrl."?page=trip-detail&trip=".$value->id; ?>">
					            	<?php echo $value->Trip_Name; ?>
					            </a>
					        </h5>
							<div class="clr h10" ></div>
							<p><span class="trip_location"><?php echo $value->Trip_Location; ?></span></p>
							<?php 
							$startTimeStamp = strtotime($value->Trip_Start_Date);
							$endTimeStamp = strtotime($value->Trip_End_Date);
							$timeDiff = abs($endTimeStamp - $startTimeStamp);
							$numberDays = $timeDiff/86400;  // 86400 seconds in one day
							// and you might want to convert to integer
							$numberDays = intval($numberDays);
							?>
							<p><?php echo $numberDays." Days / ".($numberDays - 1)." Nights"; ?></p>
							<p><?php echo date("F d-", strtotime($value->Trip_Start_Date)).date("d", strtotime($value->Trip_End_Date)); ?></p>
							<p><?php echo date("F d-", strtotime($value->Trip_2_Start_Date)).date("d", strtotime($value->Trip_2_End_Date)); ?></p>
							<p><?php echo "From $".$value->Trip_Deposit_Amount; ?></p>
							<div class="clr h20" ></div>

							<a href="<?php echo $value->Trip_Detail_Url; ?>" class="btn-nv-trip">View Details</a>
							<!-- <a href="<?php //echo $lt_plUrl."?page=trip-detail&trip=".$value->id; ?>" class="btn-nv-trip">Book Now</a> -->
							<div class="clr h30" ></div>


							<?php if($value->Show_Trip_Included == 1){ 
							
							$incOp = array("Travel Host", "Hotel & Accommodations", "City to City Transfers", "Activity Transfers", "Welcome & Farewell Dinner", "All Breakfasts", "Itinerary Activities", "Welcome Gift Boxes", "Flight", "Airport Transfers", "Incidentials", "Optional Activities & Meals (OC)");
							?>
							<div class="col-md-6 Included_part">
								<p class="text-center border-bottom ">Included</p>
								<div class="clr h10" ></div>
								<?php
								$incArr = ($value->Trip_Included != "") ? json_decode($value->Trip_Included, true) : array();
								$notIncArr = array();
								$insStrln = 0;
								$notinsStrln = 0;
								foreach ($incOp as $key2 => $value2) {
									if(in_array($value2, $incArr)){
										$insStrln = $insStrln+ strlen($value2);
										if($insStrln < 150){
											echo '<p class="text-center">'.$value2.'</p>';
										}else{
											echo '<p class="text-center">'.$value2.'...</p>';
											break;
										}
									}
								}
								?>
							</div>
							<div class="col-md-6 Not_Included_part">
								<p class="text-center  border-bottom ">Not Included</p>
								<div class="clr h10" ></div>
								<?php
								foreach ($incOp as $key2 => $value3) {
									if(!in_array($value3, $incArr)){
										$notinsStrln = $notinsStrln+ strlen($value3);
										if($notinsStrln < 150){
											echo '<p class="text-center">'.$value3.'</p>';
										}else{
											echo '<p class="text-center">'.$value3.'...</p>';
											break;
										}
									}
								}
								?>
							</div>
							<div class="clr h20" ></div>
							<?php } ?>


						</div>
						<div class="clr" ></div>
				    </div>
					<div class="clr" ></div>
			    </div>

				<?php } } ?>

				
				<div class="clr" style="height: 20px;"></div>

			</div> <!-- lt_entry_div end -->



		</div>
	</div>

	
</div> <!-- user_main_div end -->