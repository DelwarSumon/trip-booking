<div class="user_main_div" id="user_main_div">

	<style type="text/css">

		.color-yellow{

			color: #FF9B37;

		}
		.form-group{
			float:left;
		}

		.w-title{

			font-size: 24px !important;

		    float: left;

		    text-align: left;

		    padding-right: 15px !important;

		    padding-left: 15px !important;

		}

		.w-text{

			text-align: left;

		    padding-right: 15px !important;

		    padding-left: 15px !important;

		}

		.w-table{

			padding-right: 15px !important;

		    padding-left: 15px !important;

		}

		.w-table thead{

			background: #FF9B37;

			color: #FFF;

			font-weight: bold;

			text-align: left;

		}
		.flex-center{
			display: flex;
    		justify-content: center;
		}
		.d-flex{
			display: flex;
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



				if(isset($contact)){ 

				?>

				<div class="rows p2_2 ">


					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p2 flex-center">

						<form action="<?php echo $n_lt_plUrl."?page=swaiver&conid=".$_GET['conid']; ?>" method="post" enctype="multipart/form-data" id="payment-form">

							

							<input type="hidden" name="conid" value="<?php echo $contact->id; ?>">

							

							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p2 m-auto">

								

								<!-- <h4 style="margin: 0; margin-bottom: 10px;">Waiver Form</h4> -->

								<div class="clr"></div>

								

								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">First Name<sup>*</sup></label>

									<input type="text"  class="form-control"  value="<?php echo $contact->First_Name; ?>" >

								</div>

								

								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Last Name<sup>*</sup></label>

									<input type="text"  class="form-control"  value="<?php echo $contact->Last_Name; ?>" >

								</div>

								<div class="clr "></div>



								<!-- <div class="form-group col-md-8">

									<label for="" class="col-form-label float-left">Travel Experience</label>

									<input type="text"  class="form-control" value="<?php //echo $contact->Current_Trip->name; ?>" >

								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Year<sup>*</sup></label>

									<input type="text"  class="form-control"  value="<?php //echo date("Y", strtotime($contact->Current_Trip_Start_Date)); ?>" >

								</div>

								<div class="clr "></div> -->



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Address<sup>*</sup></label>

									<input type="text"  class="form-control" required="" id="Mailing_Street" name="Mailing_Street"  value="<?php echo $contact->Mailing_Street; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">City<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Mailing_City" id="Mailing_City"  value="<?php echo $contact->Mailing_City; ?>" >

								</div>



								<div class="form-group col-md-3">

									<label for="" class="col-form-label float-left">State<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Mailing_State" id="Mailing_State" value="<?php echo $contact->Mailing_State; ?>" >

								</div>



								<div class="form-group col-md-3">

									<label for="" class="col-form-label float-left">Zip<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Mailing_Zip" id="Mailing_Zip" value="<?php echo $contact->Mailing_Zip; ?>" >

								</div>

								<div class="clr h20"></div>



								<h4 class="color-yellow w-title">Shipping Address</h4>

								<div class="clr "></div>

								<label class="float-right text-right">

									<input type="checkbox" id="address_check"/>Same as above:

								</label>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Shipping Address<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Shipping_Street" id="Shipping_Street" value="<?php echo $contact->Shipping_Street; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">City<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Shipping_City" id="Shipping_City" value="<?php echo $contact->Shipping_City; ?>" >

								</div>



								<div class="form-group col-md-3">

									<label for="" class="col-form-label float-left">State<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Shipping_State" id="Shipping_State" value="<?php echo $contact->Shipping_State; ?>" >

								</div>



								<div class="form-group col-md-3">

									<label for="" class="col-form-label float-left">Zip<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Shipping_Zip" id="Shipping_Zip" value="<?php echo $contact->Shipping_Zip; ?>" >

								</div>

								<div class="clr"></div>





								<div class="clr h20"></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Mobile<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Mobile"  value="<?php echo $contact->Mobile; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">E-mail<sup>*</sup></label>

									<input type="text"  class="form-control"  value="<?php echo $contact->Email; ?>" >

								</div>

								<div class="clr h20"></div>



								<h4 class="color-yellow w-title">Birthday</h4>
								<div class="clr "></div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Month<sup>*</sup></label>

									<select class="form-control" required="" name="Birthday_Month">

										<?php 

										for ($i=1; $i <= 12; $i++) { ?>

											<option value='<?php echo $i; ?>' <?php if($i == $contact->Birthday_Month)echo 'selected="selected"'; ?> ><?php echo $i; ?></option>

										<?php  }

										?>

									</select>



								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Day<sup>*</sup></label>

									<select class="form-control" required="" name="Birthday_Day">

										<?php 

										for ($i=1; $i <= 31; $i++) { ?>

											<option value='<?php echo $i; ?>' <?php if($i == $contact->Birthday_Day)echo 'selected="selected"'; ?> ><?php echo $i; ?></option>

										<?php  }

										?>

									</select>

								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Year<sup>*</sup></label>

									<input type="number"  class="form-control" required="" name="Birthday_Year"  value="<?php echo $contact->Birthday_Year; ?>" >

								</div>

								<div class="clr h20"></div>


								<h4 class="color-yellow w-title ">Passport Info</h4>
								<div class="clr "></div>

								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Passport #<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Passport"  value="<?php echo $contact->Passport; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Passport Name<sup>*</sup><small>(exactly as written on passport)</small></label>

									<input type="text"  class="form-control" required="" name="Passport_Name"  value="<?php echo $contact->Passport_Name; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Expiration Date<sup>*</sup></label>
									<div class="clr "></div>
									<input type="date"  class="form-control" required="" name="Passport_Expiration_Date"  value="<?php echo $contact->Passport_Expiration_Date; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Issue Date<sup>*</sup></label>
									<div class="clr "></div>
									<input type="date"  class="form-control" required="" name="Passport_Issue_Date"  value="<?php echo $contact->Passport_Issue_Date; ?>" >

								</div>

								<div class="clr h20"></div>

								

								<h4 class="color-yellow w-title">Personal Info</h4>
								<div class="float-left" style="padding-left: 15px;"><small><i>This will help us select the perfect roommate for your travel experience.</i></small></div>
								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Instagram Handle</label>

									<input type="text"  class="form-control" name="Instagram"  value="<?php echo $contact->Instagram; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Facebook</label>

									<input type="text"  class="form-control" name="Facebook"  value="<?php echo $contact->Facebook; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Relationship Status</label>

									<select name="Relationship_Status"  class="form-control">

										<option value="">-None-</option>

										<option value="Single" <?php if($contact->Relationship_Status== "Single")echo 'selected="selected"'; ?>>Single</option>

										<option value="Married" <?php if($contact->Relationship_Status== "Married")echo 'selected="selected"'; ?>>Married</option>

										<option value="Widowed" <?php if($contact->Relationship_Status== "Widowed")echo 'selected="selected"'; ?>>Widowed</option>

										<option value="Separated" <?php if($contact->Relationship_Status== "Separated")echo 'selected="selected"'; ?>>Separated</option>

										<option value="Divorced" <?php if($contact->Relationship_Status== "Divorced")echo 'selected="selected"'; ?>>Divorced</option>

									</select>

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Children</label>

									<select name="Children"  class="form-control">
										<option value="">-None-</option>
										<option value="Yes" <?php if($contact->Children== "Yes")echo 'selected="selected"'; ?>>Yes</option>
										<option value="No" <?php if($contact->Children== "No")echo 'selected="selected"'; ?>>No</option>
									</select>
								</div>

								<div class="clr "></div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Profession</label>

									<input type="text"  class="form-control" name="Job_Title"  value="<?php echo $contact->Job_Title; ?>" >

								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Early Bird</label>

									<select name="Early_Bird"  class="form-control">
										<option value="">-None-</option>
										<option value="Yes" <?php if($contact->Early_Bird== "Yes")echo 'selected="selected"'; ?>>Yes</option>
										<option value="No" <?php if($contact->Early_Bird== "No")echo 'selected="selected"'; ?>>No</option>
									</select>
								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Party Animal</label>

									<select class="form-control" name="Party_Animal">
										<?php 
										for ($i=1; $i <= 10; $i++) { ?>
											<option value='<?php echo $i; ?>' <?php if($i == $contact->Party_Animal)echo 'selected="selected"'; ?> ><?php echo $i; ?></option>
										<?php  }?>
									</select>
								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Smoker</label>

									<input type="text"  class="form-control"  name="Smoker"  value="<?php echo $contact->Smoker; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Fitness Freak</label>

									<select class="form-control" name="Fitness_Level">
										<?php 
										for ($i=1; $i <= 10; $i++) { ?>
											<option value='<?php echo $i; ?>' <?php if($i == $contact->Fitness_Level)echo 'selected="selected"'; ?> ><?php echo $i; ?></option>
										<?php  }?>
									</select>
								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Shirt Size</label>

									<select name="Shirt_Size"  class="form-control">
										<option value="">-None-</option>
										<option value="XS" <?php if($contact->Shirt_Size== "XS")echo 'selected="selected"'; ?>>XS</option>
										<option value="S" <?php if($contact->Shirt_Size== "S")echo 'selected="selected"'; ?>>S</option>
										<option value="M" <?php if($contact->Shirt_Size== "M")echo 'selected="selected"'; ?>>M</option>
										<option value="L" <?php if($contact->Shirt_Size== "L")echo 'selected="selected"'; ?>>L</option>
										<option value="XL" <?php if($contact->Shirt_Size== "XL")echo 'selected="selected"'; ?>>XL</option>
										<option value="XXL" <?php if($contact->Shirt_Size== "XXL")echo 'selected="selected"'; ?>>XXL</option>
									</select>
								</div>





								<div class="clr h20"></div>

								<h4 class="color-yellow w-title">Health Info </h4>
								<div class="float-left" style="padding-left: 15px;"><small><i>All health information is confidential.</i></small></div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Medications</label>

									<input type="text"  class="form-control"  name="Guestmedications"  value="<?php echo $contact->Guestmedications; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Allergies</label>

									<input type="text"  class="form-control"  name="Allergies"  value="<?php echo $contact->Allergies; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Additional Information We Should Be Aware Of</label>

									<textarea class="form-control"  name="Additional_Information_We_Should_Be_Aware_Of" ><?php echo $contact->Additional_Information_We_Should_Be_Aware_Of; ?></textarea>

								</div>

								<div class="clr "></div>


								<div class="clr h20"></div><h4 class="color-yellow w-title">Emergency Contact</h4>

								<div class="clr "></div>



								<div class="form-group col-md-5">

									<label for="" class="col-form-label float-left">Name<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Emergency_Name"  value="<?php echo $contact->Emergency_Name; ?>" >

								</div>



								<div class="form-group col-md-4">

									<label for="" class="col-form-label float-left">Relationship<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Emergency_Relation"  value="<?php echo $contact->Emergency_Relation; ?>" >

								</div>



								<div class="form-group col-md-3">

									<label for="" class="col-form-label float-left">Phone<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Emergency_Phone"  value="<?php echo $contact->Emergency_Phone; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-5">

									<label for="" class="col-form-label float-left">E-mail<sup>*</sup></label>

									<input type="text"  class="form-control" required="" name="Emergency_Email"  value="<?php echo $contact->Emergency_Email; ?>" >

								</div>



								<div class="form-group col-md-7">

									<label for="" class="col-form-label float-left">Instagram</label>

									<input type="text"  class="form-control" name="Emergency_Instagram"  value="<?php echo $contact->Emergency_Instagram; ?>" >

								</div>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">Flight Info</h4>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Airline</label>

									<input type="text"  class="form-control"  name="Airline"  value="<?php echo $contact->Airline; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Flight</label>

									<input type="text"  class="form-control" name="Flight"  value="<?php echo $contact->Flight; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Arrival Date</label>
									<div class="clr "></div>
									<input type="date"  class="form-control"  name="Arrival_Date"  value="<?php if($contact->Arrival_Date != "")echo $contact->Arrival_Date; ?>" >

								</div>



								<div class="form-group col-md-6">

									<label for="" class="col-form-label float-left">Arrival Time</label>
									<div class="clr "></div>
									<input type="time"  class="form-control"  name="Arrival_Time"  value="<?php echo $contact->Arrival_Time; ?>" >

								</div>

								<div class="clr h20"></div>

								<h4 class="color-yellow w-title">Travel Experience</h4>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">How many countries have you visited?</label>

									<input type="text"  class="form-control" name="How_Many_Countries_Have_You_Been_To"  value="<?php echo $contact->How_Many_Countries_Have_You_Been_To; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Top 3 Places Traveled</label>
									<div class="clr"></div>
									<div class="d-flex">
										<input type="text"  class="form-control mr-2 mb-2" name="Top_3_Places_Traveled"  value="<?php echo $contact->Top_3_Places_Traveled; ?>" >
										<input type="text"  class="form-control mr-2 mb-2" name="Top_3_Places_Traveled_2"  value="<?php echo $contact->Top_3_Places_Traveled_2; ?>" >
										<input type="text"  class="form-control mb-2" name="Top_3_Places_Traveled_3"  value="<?php echo $contact->Top_3_Places_Traveled_3; ?>" >
									</div>
								</div>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Favorite Experience</label>

									<input type="text"  class="form-control" name="Favorite_Experience"  value="<?php echo $contact->Favorite_Experience; ?>" >

								</div>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Top 3 Bucket List Countries</label>
									<div class="clr"></div>
									<div class="d-flex">
										<input type="text"  class="form-control mr-2 mb-2" name="Top_5_Bucket_List_Countries"  value="<?php echo $contact->Top_5_Bucket_List_Countries; ?>" >
										<input type="text"  class="form-control mr-2 mb-2" name="Top_3_Bucket_List_Countries_2"  value="<?php echo $contact->Top_3_Bucket_List_Countries_2; ?>" >
										<input type="text"  class="form-control float-right mb-2" name="Top_3_Bucket_List_Countries_3"  value="<?php echo $contact->Top_3_Bucket_List_Countries_3; ?>" >

									</div>
								</div>

								<div class="clr "></div>



								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Best Months for you to travel</label>

									<input type="text"  class="form-control" name="Best_Months_For_You_To_Travel"  value="<?php echo $contact->Best_Months_For_You_To_Travel; ?>" >

								</div>

								<div class="clr "></div>



								<!-- <div class="form-group col-md-12">

									<label for="" class="col-form-label float-left">Notes</label>

									<textarea class="form-control" name="Guest_Notes" ><?php //echo $contact->Guest_Notes; ?></textarea>

								</div> -->

								<div class="clr "></div>



								<!-- <p class="w-text">This document outlines what Travr LLC agrees to provide when you sign up for a tour, and what you agree to do in return. This is very important information, so please read it carefully before signing.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">PRICING</h4>

								<div class="clr "></div>



								<p class="w-text">Tour price guarantee: Our tour prices do not include airfare, and are subject to change without notice due to the unpredictability of currency rates and trip costs. However, your price for the tour you’ve selected will be locked and guaranteed the moment we receive your deposit or payment in full along with your signed waiver.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">INCLUDED IN THE PRICE OF EACH TOUR</h4>

								<div class="clr "></div>

								<p class="w-text">Accompaniment and sightseeing tours by a personal travr guide, and local guides when appropriate, including activities marked “I” on the itinerary; breakfasts (except on early departure days) and included dinners per tour itinerary, accommodations, city to city transportation (does not include intercity transportation, optional activities or independent travel during the tour). The places we travel can be full of surprises and we need to be flexible enough to take advantage of whatever comes along so that we may provide you with the best possible tour. Uncompleted portions of the tour itinerary are not cause for refund or partial refund.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">NOT INCLUDED</h4>

								<div class="clr "></div>

								<p class="w-text">

									Additional meals, beverages and hotel charges, including mini bar & room incidentals. Any and all intercity transportation, including cabs, metro, subway, buses and any other forms of transportation other than the city to city transfer provided. Any and all free time activities, including meals, beverages, optional itinerary activities (marked OC = optional cost on itinerary) and any and all nighttime and free time activities.

								</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">PARTICIPATION</h4>

								<div class="clr "></div>

								<p class="w-text">We want everyone to have a great time, but in the event that someone participating in a tour behaves inappropriately including violence of any kind, drug use or do things that are incompatible with the safety, comfort or convenience of other members of the tour, we reserve the exclusive right and discretion, to expel any tour member(s) from any tour at any time, at the guests expense, without any claims or complaints by you against us. This includes aggressive behavior, physical contact and or language used towards the travr guide, another guest, and the staff of our accommodations, transportation, planned activities or others in general. Tour guests are expected to be flexible, open-minded and considerate toward their roommates and one another during the duration of the tour.</p>



								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">TRAVR TOURS CAN BE PHYSICALLY ACTIVE</h4>

								<div class="clr "></div>



								<p class="w-text">This is an integral, essential part of the travr experience. On any tour you should be capable of fully and happily participating — without any assistance — in the following levels of activity: Carry or roll your own luggage for up to 15 minutes over uneven pavement from the bus to the hotel, between transfers, transporting luggage up numerous flights of stairs to your room. Many European and Asian hotels (even 5 stars) do not provide elevators and when provided most fit a max of 2 occupants. Although all itinerary activities are optional, if you do elect to participate in strenuous activities, you should be comfortable on your feet for an extended period of time for walking tours, stairs, hopping on and off public transportation, and standing or walking in various weather conditions.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">PLEASE PACK LIGHT</h4>

								<div class="clr "></div>



								<p class="w-text">Packing light makes all the difference. Because there is limited space on various transportation means during our trips we highly suggest following our luggage recommendations for each of our tours (Provided within booking emails). If guest chooses to exceed recommended luggage suggestion they will be fully responsible for additional luggage and transportation costs if the situation occurs. In addition, guest will be transporting their your own luggage between all various transfers, to their accommodations, sometimes up numerous stairs, over cobblestone and various difficult terrain. Guest is fully responsible for transporting their own luggage throughout entire trip.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">SOLO TRAVELERS AND SINGLE SUPPLEMENTS</h4>

								<div class="clr "></div>



								<p class="w-text">If you are traveling solo, you need not pay the mandatory single supplement often required by other tour companies. You will most likely room with another tour member of the same sex. If you wish to guarantee a private room, we offer a limited number of optional single supplements for an additional fee. Please note that a single supplement guarantees a private room — not a larger or nicer room - not a guaranteed king or queen bed, as European & Asian single-bed rooms are generally the smallest and most basic rooms the hotel has to offer.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">TOUR CANCELLATION</h4>

								<div class="clr "></div>



								<p class="w-text">Travr knows that sometimes the best-laid plans go wrong. That is why we offer the following cancellation policy. Unlike many other companies who do not offer such a return policy, we do this purely as a courtesy for your benefit, and for the benefit of your traveling partner(s) or family member(s). If we cancel a tour for any reason, you have reserved: the entire amount you have paid to travr for the applicable tour will be refunded to you within 14 days after the tour’s cancellation. Or, you may choose to transfer to another tour with seats available. Once your deposit refund date has passed (60 days before tour begins), we cannot refund your deposit money under any circumstance other than the cancellation of the trip via travr. Please notify travr immediately in case of an unforeseen cancellations: adventures@travr.life.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">REFUND POLICY</h4>

								<div class="clr "></div>



								<p class="w-text">Travr will not refund your tour payments in any amount outside of our refund policy: Carrier-related delays, including those caused by bad weather, labor disputes, civil unrest or mechanical problems. Personal problems or difficulties that are not medically disabling, business problems or emergencies, governmental obligations or requirements related to subpoenas, summons, jury duty or lawsuits, war, terrorism or the Immigration and Naturalization Service. Your inability to obtain a passport or visa or other travel-related document, self-inflicted injury or harm, problems related to alcohol or substance abuse. Personal injuries caused by high-risk personal activities such as skydiving, racing or bungee cord jumping. Incomplete Release and Waiver. Non-qualifying reason.</p>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">PAYMENT</h4>

								<div class="clr "></div>



								<p class="w-text">Full Balance can be paid at anytime and is is due anytime before 60 days of departure. Failure to pay balance on time will result in loss of deposit and loss of reservation.</p>

								<div class="clr h20"></div>

								<div class="table-responsive w-table">

									<table class="table table-striped">

										<thead >

											<tr>

												<th>DAYS FROM DEPARTURE</th>

												<th>PAID IN FULL</th>

												<th>DEPOSIT ONLY</th>

											</tr>

										</thead>

										<tbody>

											<tr>

												<td>Over 91 Days</td>

												<td>Full Refund</td>

												<td>Full Refund</td>

											</tr>

											<tr>

												<td>90 Days or Less</td>

												<td>Deposit Becomes Credit</td>

												<td>Deposit Becomes Credit</td>

											</tr>

											<tr>

												<td>60 Days or Less</td>

												<td>No Refund / No Transfer</td>

												<td>No Refund / No Transfer</td>

											</tr>

											<tr>

												<td>30 Days or Less</td>

												<td>No Refund / No Transfer</td>

												<td>No Refund / No Transfer</td>

											</tr>

										</tbody>

									</table>

								</div>

								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">RELEASE AND WAIVER AGREEMENT FOR TRAVR</h4>

								<div class="clr "></div>



								<p class="w-text">Accidents can happen anywhere, even on a trip to the grocery store. However, traveling anywhere outside the United States, even with travr, can involve risks and hazards that are far greater than usual. By signing this document, you agree to assume all the risks of traveling, however great or slight they may be. Because of how and where we travel, and because of the forces of nature (including human nature), you understand that injuries, illnesses, losses, and inconveniences can occur in remote places where there is no ready assistance or medical care.</p>

								<p class="w-text">You also understand that travr and all of his and their employees, agents, officers, contractors, and representatives do not provide any medical, health, or related services. Although we will assist in any way possible, you agree to primarily take care of your own health needs, and the needs of your spouse and family (if any).</p>

								<p class="w-text">We expect your travel experience will be safe, pleasurable, fun and exciting. Nevertheless, you agree that if something goes wrong, or you have any disputes with us regarding anything, currently or in the future, by signing this Agreement and/or by participating in a tour with travr, you have waived and released any claims you could have brought against us.</p>

								<p class="w-text">Part of the fun, and part of the risk, of travel is that food, water, lodging, and local customs can be very different from what you are used to. Thus, this waiver and release includes, by way of example, and not by way of limitation, any claims you may have regarding: tour accommodations; food service, quality or quantity; transportation; sightseeing; or your itinerary, which is subject to change without notice or any full or partial refund.</p>

								<p class="w-text">Other examples of the claims you are waiving and releasing include, without limitation: strikes; theft; political instability; poor roads or public services or transportation; actions by police, customs or local law officials; inclement weather; and civil unrest, even events of war, sabotage, or terrorism, or other accidental harm to you.</p>

								<p class="w-text">You understand and agree that you have waived and released and cannot ever bring a claim against us for anything, including without limitation property damage, personal injury, damage to your reputation, discrimination, harassment, failure to accommodate you, emotional distress, outrage, or even death, or for any other event or situation that occurs, or any other claim that you may have, even if it is not specifically listed in this document.</p>



								<div class="clr "></div>



								<div class="clr h20"></div><h4 class="color-yellow w-title">RELEASE AND WAIVER AGREEMENT FOR TRAVR (CONT.)</h4>

								<div class="clr "></div>

								<p class="w-text">Because it is impossible to foresee everything that can possibly go wrong, you agree that you have released and waived all claims you may ever have against us, even claims that are unknown, unknowable, unanticipated, or unforeseeable. You also understand and agree that if someone asserts a claim or demand or cause of action against you that arises out of or relates to this tour, you agree that you have waived and released any right you may have had to seek contribution or indemnity or defense from us.</p>

								<p class="w-text">Being on a tour with other people is not a private activity, therefore you acknowledge and permit that photos and videos of yourself and your family members may be taken and may appear in albums and scrapbooks, on websites, in various promotional and marketing material, and that you have waived and released any rights that you may have to make a claim against us if and when such a thing may occur.</p>

								<p class="w-text">Your signature below means that you have read and fully understand this travr Release and Waiver Agreement.</p>

								<div class="clr h30"></div>



								<h5>After reviewing this document, please click submit to travr.</h5> -->



								<div class="clr h20"></div>

								<div class="form-group col-md-12">

									<input type="submit" name="" class="btn-nv-trip" value="Submit" />

								</div>

								<div class="clr "></div>



							</div>

							<div class="clr h20"></div>



							



						</form>

					</div>
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



	

	<script type="text/javascript">

		jQuery(document).ready(function(){

			jQuery(".logo").find('img').attr("src", "http://new.travr.life/wp-content/uploads/2021/06/travrlogopic-1.jpg");

			// jQuery(".user_main_div").prev().html("<h3>Waiver <strong>Form</strong></h3>");



			// jQuery('html, body').animate({

		 //        scrollTop: jQuery("#user_main_div").offset().top

		 //    }, 2000);



			jQuery('#address_check').click(function(){

			  	if (jQuery(this).is(":checked")) {

    				jQuery('#Shipping_Street').val(jQuery('#Mailing_Street').val());

    				jQuery('#Shipping_City').val(jQuery('#Mailing_City').val());

    				jQuery('#Shipping_State').val(jQuery('#Mailing_State').val());

    				jQuery('#Shipping_Zip').val(jQuery('#Mailing_Zip').val());

				}else{

					jQuery('#Shipping_Street').val("");

    				jQuery('#Shipping_City').val("");

    				jQuery('#Shipping_State').val("");

    				jQuery('#Shipping_Zip').val("");

				}

			});

		});

	</script>



</div>