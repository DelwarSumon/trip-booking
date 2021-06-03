<div class="admin_main_div">



<?php if(session_id() == ''){ session_start(); } ?>







	<!-- date time picker js css -->



	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>



	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>



	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />



	<!-- date time picker js css end -->



	<!-- select2 js css -->

	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

	<!-- select2 js css end -->







<?php if(!empty($_SESSION['status'])){ $status = ($_SESSION['status'] == 'success') ? 'success' : 'danger'; ?>



	<div class="row">



		<div class="col-md-8">



			<div class="alert alert-<?php echo $status ?>"><?php echo $_SESSION['msg']; ?></div>



		</div>



	</div>



<?php 



unset($_SESSION['status']);



unset($_SESSION['msg']);



} ?>















	<div class="row">



		<div class="col-md-12">



			<div class="card">



				<div class="row card-title">



					<div class="col-md-12 float-left">

						<h4 class="float-left">Trips</h4>



						<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" enctype="multipart/form-data">

							<input type="hidden" name="action" value="wp_import_pro" />

							<button type="submit" class="btn btn-primary float-right">Import</button>

						</form>

					</div>







				</div>



				<div class="card-body">



					<div class="lottery_ad_div">



					    <div class="clr"></div>



						<ul class="nav nav-tabs">

						    <li class="active"><a data-toggle="tab" id="tab-TripList_Admin" href="#TripList_Admin">Trip Lists</a></li>



						    <li><a data-toggle="tab" id="tab-AddTrip_Admin" href="#AddTrip_Admin">Add Trip</a></li>

					  	</ul>



					  	<div class="tab-content" style="margin-top: 30px;">



						    <div id="TripList_Admin" class="tab-pane fade in active">



						      	<div class="col-md-12">



						      		<div class="table-responsive">



						      			<table class="table table-striped table-bordered dTable" style="width:100%">



											<thead>



												<tr>

													<th style="">Trip Name</th>

													<th style="">Trip Location</th>

													<th style="">Checkout Url</th>

													<th style="">Trip Description</th>

													<th style="">Trip Start Date</th>

													<th style="">Trip End Date</th>

													<th style="">Total Seats Available</th>

													<th style="">Total Price</th>

													<th style="">Single Room Price</th>

													<th style="">Single Room Total Price</th>





													<th style="">Tier 2 Date or Amount Sold</th>

													<th style="">Increase Amount</th>

													<th style="">Tier 3 Date or Amount Sold</th>

													<th style="">Increase Amount $100</th>



													<th style="">Deposit Amount</th>

													<th style="">Payment Due Date</th>

													<!-- <th style="">Action</th> -->



												</tr>



											</thead>



											<tbody>



												<?php if(isset($results)){

													foreach ($results as $key => $value) {

												?>

												<tr>

													<td><?php echo $value->Trip_Name; ?></td>

													<td><?php echo $value->Trip_Location; ?></td>

													<td><?php echo site_url()."/booking-and-checkout/?page=trip-detail&trip=".$value->id; ?></td>

													<td><?php echo $value->Trip_Description; ?></td>

													<td><?php echo $value->Trip_Start_Date; ?></td>

													<td><?php echo $value->Trip_End_Date; ?></td>

													<td><?php echo $value->Total_Number_of_Seat; ?></td>

													<td><?php echo $value->Trip_Total_Price; ?></td>

													<td><?php echo $value->Trip_Single_Room_Price; ?></td>

													<td><?php echo $value->Trip_Single_Room_Total_Price; ?></td>

													<td><?php echo $value->Tier_2_Date; ?></td>

													<td><?php echo $value->Tier_2_Increase_Amount; ?></td>

													<td><?php echo $value->Tier_3_Date; ?></td>

													<td><?php echo $value->Tier_3_Increase_Amount; ?></td>

													<td><?php echo $value->Payment_Due_Date; ?></td>

													<td><?php echo $value->Trip_Deposit_Amount; ?></td>

													<!-- <td> -->



														<!-- <div style="display: inline-grid;">



															<form action="<?php //echo esc_url( admin_url('admin-post.php') ); ?>" method="post">



																<input type="hidden" name="action" value="delete_lottery">



																<input type="hidden" name="idd" class="id" value="<?php //echo $results->id; ?>">



																<input type="submit" class="btn btn-danger btn-sm" value="Delete">



															</form>



														</div> -->



													<!-- </td> -->



												</tr>



											<?php  } }  ?>



											</tbody>



										</table>



						      		</div>



						      	</div>











						    </div> <!-- TripList_Admin end -->







						    <div id="AddTrip_Admin" class="tab-pane fade">







						      	<div class="col-md-12">







						      		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" enctype="multipart/form-data">



            							<input type="hidden" name="action" value="wp_add_trip_admin" />



            							<div class="row shadow_box" >

							      			<div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Name<sup>*</sup></label>

												<input type="text"  class="form-control" name="Trip_Name" value="" required="required">

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Location<sup>*</sup></label>

												<input type="text"  class="form-control" name="Trip_Location" value="" required="required">

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Detail Url<sup>*</sup></label>

												<input type="text"  class="form-control" name="Trip_Detail_Url" value="" required="required">

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Description<sup>*</sup></label>

												<textarea class="form-control" name="Trip_Description" value="" required="required"></textarea>

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-12" >

												<label for="" class="col-form-label">Trip Image Url</label>

												<input type="text"  class="form-control" name="Trip_Image_Url" value="">

											</div>



											<div class="clr"></div>

										</div>

										<div class="clr h20"></div>



            							<div class="row shadow_box" >

											<h4 class="col-md-12 card-title">Trip 1 Details</h4>



							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Trip Start Date<sup>*</sup></label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_Start_Date" value="<?php echo date('Y-m-d', strtotime('+2 months')); ?>" required="required"/>

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip End Date<sup>*</sup></label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_End_Date" value="<?php echo date('Y-m-d', strtotime('+2 months 10 days')); ?>" required="required"/>

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>

											<div class="clr"></div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Total Seats Available<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Total_Number_of_Seat" required="required">

											</div>



							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Total Price<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Trip_Total_Price" required="required">

											</div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip Single Room Price<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Trip_Single_Room_Price" required="required">

											</div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip Single Room Total Price<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Trip_Single_Room_Total_Price" required="required">

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Tier 2 Date<sup>*</sup></label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Tier_2_Date" value="" required="" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Increase Amount<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Tier_2_Increase_Amount" required="required">

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Tier 3 Date<sup>*</sup></label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Tier_3_Date" value="" required="" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Increase Amount<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Tier_3_Increase_Amount" required="required">

											</div>

											<div class="clr"></div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Deposit Amount<sup>*</sup></label>

												<input type="text"  class="form-control" value="" name="Trip_Deposit_Amount" required="required">

											</div>

											

											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Payment Due Date<sup>*</sup></label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Payment_Due_Date" value="<?php echo date('Y-m-d', strtotime('+2 months')); ?>" required="required"/>

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>

											<div class="clr"></div>

											

											<!-- <div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Included</label>

												<select class="js-example-basic-multiple form-control" name="Trip_Included[]" multiple="multiple">

												  	<option value="Travel Host">Travel Host</option>

												  	<option value="Hotel & Accommodations">Hotel & Accommodations</option>

												  	<option value="City to City Transfers">City to City Transfers</option>

												  	<option value="Activity Transfers">Activity Transfers</option>

												  	<option value="Welcome & Farewell Dinner">Welcome & Farewell Dinner</option>

												  	<option value="All Breakfasts">All Breakfasts</option>

												  	<option value="Itinerary Activities">Itinerary Activities</option>

												  	<option value="Welcome Gift Boxes">Welcome Gift Boxes</option>

												  	<option value="Flight">Flight</option>

												  	<option value="Airport Transfers">Airport Transfers</option>

												  	<option value="Incidentials">Incidentials</option>

												  	<option value="Optional Activities & Meals (OC)">Optional Activities & Meals (OC)</option>

												</select>

											</div>

											<div class="clr"></div> -->







										</div>



										<div class="clr h20"></div>

            							<div class="row shadow_box" >



											<h4 class="col-md-12 card-title">Trip 2 Details</h4>

							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Trip 2 Start Date</label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_2_Start_Date" value="" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip 2 End Date</label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_2_End_Date" value="" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Total Seats Available</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Total_Number_of_Seat" >

											</div>



							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Total Price</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Total_Price" >

											</div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip Single Room Price</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Single_Room_Price" >

											</div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Trip Single Room Total Price</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Single_Room_Total_Price" >

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Tier 2 Date</label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_2_Tier_2_Date" value="" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Increase Amount</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Tier_2_Increase_Amount" >

											</div>

											<div class="clr"></div>



							      			<div class="form-group col-md-6">



												<label for="" class="col-form-label">Tier 3 Date</label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_2_Tier_3_Date" value=""  />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>



											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Increase Amount</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Tier_3_Increase_Amount" >

											</div>

											<div class="clr"></div>

											

							      			<div class="form-group col-md-6">

												<label for="" class="col-form-label">Deposit Amount</label>

												<input type="text"  class="form-control" value="" name="Trip_2_Deposit_Amount" >

											</div>

											

											<div class="form-group col-md-6">

												<label for="" class="col-form-label">Payment Due Date</label>

												<div class='input-group date datetimepicker' >

								                    <input type='text' class="form-control" name="Trip_2_Payment_Due_Date" value="<?php //echo date('Y-m-d', strtotime('+2 months')); ?>" />

								                    <span class="input-group-addon">

								                        <span class="glyphicon glyphicon-calendar"></span>

								                    </span>

								                </div>

											</div>

						      				<div class="clr"></div>





											

											<!-- <div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Included</label>

												<select class="js-example-basic-multiple form-control" name="Trip_2_Included[]" multiple="multiple">

												  	<option value="Travel Host">Travel Host</option>

												  	<option value="Hotel & Accommodations">Hotel & Accommodations</option>

												  	<option value="City to City Transfers">City to City Transfers</option>

												  	<option value="Activity Transfers">Activity Transfers</option>

												  	<option value="Welcome & Farewell Dinner">Welcome & Farewell Dinner</option>

												  	<option value="All Breakfasts">All Breakfasts</option>

												  	<option value="Itinerary Activities">Itinerary Activities</option>

												  	<option value="Welcome Gift Boxes">Welcome Gift Boxes</option>

												  	<option value="Flight">Flight</option>

												  	<option value="Airport Transfers">Airport Transfers</option>

												  	<option value="Incidentials">Incidentials</option>

												  	<option value="Optional Activities & Meals (OC)">Optional Activities & Meals (OC)</option>

												</select>

											</div>

											<div class="clr"></div> -->



										</div>



										<div class="clr h20"></div>

            							<div class="row shadow_box" >

											<div class="form-group col-md-12">

												

												<label for="" class="col-form-label">Trip Promo Code</label>

												<input type="text"  class="form-control" value="" name="Trip_Promo_Code" >

											</div>

											<div class="clr"></div>



											<div class="form-group col-md-12">

												<label for="" class="col-form-label">Trip Included</label>

												<select class="js-example-basic-multiple form-control" name="Trip_Included[]" multiple="multiple">

												  	<option value="Travel Host">Travel Host</option>

												  	<option value="Hotel & Accommodations">Hotel & Accommodations</option>

												  	<option value="City to City Transfers">City to City Transfers</option>

												  	<option value="Activity Transfers">Activity Transfers</option>

												  	<option value="Welcome & Farewell Dinner">Welcome & Farewell Dinner</option>

												  	<option value="All Breakfasts">All Breakfasts</option>

												  	<option value="Itinerary Activities">Itinerary Activities</option>

												  	<option value="Welcome Gift Boxes">Welcome Gift Boxes</option>

												  	<option value="Flight">Flight</option>

												  	<option value="Airport Transfers">Airport Transfers</option>

												  	<option value="Incidentials">Incidentials</option>

												  	<option value="Optional Activities & Meals (OC)">Optional Activities & Meals (OC)</option>

												</select>

											</div>

											<div class="clr"></div>

										</div>





						      			<div class="clr h20"></div>

						      			<div class="form-group col-md-12">

											<input class="btn btn-primary width150" name="submit" type="submit" value="Save"/>

										</div>



						      		</form>







						      	</div>







						    </div> <!-- AddTrip_Admin end -->



						    



						    <div class="clr"></div>







					  	</div> <!-- tab-content end -->







					    <div class="clr"></div>







					</div>



				</div> <!-- card-body end -->



			</div> <!-- card end -->



		</div>



	</div>











<?php if(!empty($_SESSION['tab'])){ ?>



<script type="text/javascript">



	jQuery(function () {



        jQuery("#tab-<?php echo $_SESSION['tab']; ?>").click();



    });



</script>



<?php unset($_SESSION['tab']);	} ?>



<script type="text/javascript">

	$(document).ready(function() {

	    $('.js-example-basic-multiple').select2();

	});

</script>















</div> <!-- admin_main_div end -->







<script type="text/javascript">



	jQuery(function () {



        jQuery('.datetimepicker').datetimepicker({



        	format: 'YYYY-MM-DD'

        	// format: 'YYYY-MM-DD HH:mm:ss'



        });



    });



</script>