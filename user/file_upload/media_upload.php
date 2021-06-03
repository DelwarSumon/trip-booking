<div class="user_main_div" id="user_main_div">

	<style type="text/css">

		.color-yellow{

			color: #FF9B37;

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

					<form action="<?php echo $n_lt_plUrl."?page=upfile&conid=".$_GET['conid']; ?>" method="post" enctype="multipart/form-data" >

						

						<input type="hidden" name="conid" value="<?php echo $contact->crm_id; ?>">

						

						<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 p2 ">

							

							<div class="clr"></div>

							<div style="padding: 20px;border: 1px solid #ff7e2c;">

								<div class="form-group col-md-12">

									<label for="" class="col-form-label float-left"><?php echo isset($show_label) ? $show_label : "Upload Media"; ?><sup>*</sup></label>

									<input type="file"  class="form-control" required="" name="md_upload" >

								</div>

								<div class="clr "></div>

							</div>



							<div class="clr h20"></div>

							<div class="form-group col-md-12">

								<input type="submit" name="" class="btn-nv-trip" value="Submit" />

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
		<div class="col-sm-12"  style="text-align: center;">
		    <h3><strong>Life Begins</strong> at the <strong>End</strong> of Your <strong>Comfort Zone</strong></h3>
		</div>
	</div>

	

	<script type="text/javascript">

		$(document).ready(function(){

			$(".user_main_div").parent().find("h3:first").html('<?php echo $show_heading; ?>');

		});

	</script>



</div>