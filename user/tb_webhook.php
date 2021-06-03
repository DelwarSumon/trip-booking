<?php

if(isset($_GET['id']) && (strlen($_GET['id']) > 8) && (isset($_GET['acfor'])) && ($_GET['acfor'] != "") ){



	global $wpdb;

	include_once __DIR__ .'../../classes/Nzoho.php';



	$Nzoho = new Nzoho;

	$module = "Products"; 

	$crm_id = $_GET['id']; 
	$acfor = $_GET['acfor']; 
	$table_name = $wpdb->prefix."tb_trips_tbl";

	// for create edit 
	if($acfor == "create-edit"){
		$zc_data_page = $Nzoho->getRecordsById($crm_id, $module);

		$zc_data_pageArr = json_decode($zc_data_page);




		if(isset($zc_data_pageArr->data[0])){

			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){

				$data = $zc_data_pageArr->data[0];

				$local = array();

				$local['crm_id'] = $data->id;

				$local['Trip_Name'] = $data->Product_Name;

				$local['Trip_Location'] = $data->Trip_Location;

				$local['Trip_Image_Url'] = $data->Trip_Image_Url;

				$local['Trip_Detail_Url'] = $data->Trip_Detail_Url;

				$local['Trip_Description'] = $data->Trip_Description;



				$local['Trip_Start_Date'] = $data->Trip_Start_Date;

				$local['Trip_End_Date'] = $data->Trip_End_Date;

				$local['Total_Number_of_Seat'] = $data->Total_Number_of_Seat;

				$local['Trip_Total_Price'] = $data->Trip_Total_Price;

				$local['Trip_Single_Room_Price'] = $data->Trip_Single_Room_Price;

				$local['Trip_Single_Room_Total_Price'] = $data->Trip_Single_Room_Total_Price;

				$local['Tier_2_Date'] = $data->Tier_2_Date;

				$local['Tier_2_Increase_Amount'] = $data->Tier_2_Increase_Amount;

				$local['Tier_3_Date'] = $data->Tier_3_Date;

				$local['Tier_3_Increase_Amount'] = $data->Tier_3_Increase_Amount;

				$local['Trip_Deposit_Amount'] = $data->Trip_Deposit_Amount;

				$local['Payment_Due_Date'] = $data->Payment_Due_Date;

				$local['Seat_Booked'] = $data->Seat_Booked;

				$local['Trip_Included'] = json_encode($data->Trip_Included);
				$local['Show_Trip_Included'] = $data->Show_Trip_Included;

				$local['Trip_Promo_Code'] = $data->Trip_Promo_Code;



				$local['Trip_2_Start_Date'] = $data->Trip_2_Start_Date;

				$local['Trip_2_End_Date'] = $data->Trip_2_End_Date;

				$local['Trip_2_Total_Number_of_Seat'] = $data->Trip_2_Total_Number_of_Seat;

				$local['Trip_2_Total_Price'] = $data->Trip_2_Total_Price;

				$local['Trip_2_Single_Room_Price'] = $data->Trip_2_Single_Room_Price;

				$local['Trip_2_Single_Room_Total_Price'] = $data->Trip_2_Single_Room_Total_Price;

				$local['Trip_2_Tier_2_Date'] = $data->Trip_2_Tier_2_Date;

				$local['Trip_2_Tier_2_Increase_Amount'] = $data->Trip_2_Tier_2_Increase_Amount;

				$local['Trip_2_Tier_3_Date'] = $data->Trip_2_Tier_3_Date;

				$local['Trip_2_Tier_3_Increase_Amount'] = $data->Trip_2_Tier_3_Increase_Amount;

				$local['Trip_2_Deposit_Amount'] = $data->Trip_2_Deposit_Amount;

				$local['Trip_2_Payment_Due_Date'] = $data->Trip_2_Payment_Due_Date;

				$local['Trip_2_Seat_Booked'] = $data->Trip_2_Seat_Booked;

				$local['Trip_2_Included'] = $data->Trip_2_Included;

				$local['zoho_data'] = json_encode($data);

				

				$trips = $wpdb->get_row( "SELECT * FROM $table_name where crm_id = '$crm_id' ");

				if(isset($trips->id)){

					$update =  $wpdb->update( $table_name,$local,array( 'id' => $trips->id));

				}else{

					$local['Trip_Included'] = '["Travel Host","Hotel & Accommodations","City to City Transfers","Activity Transfers","Welcome & Farewell Dinner","All Breakfasts","Itinerary Activities","Welcome Gift Boxes"]';

					$insert = $wpdb->insert( $table_name, $local);

				}



			}

			// else{ echo $table_name."  table is not existis."; }  

		}
	
	}

	// for delete
	if($acfor == "delete"){
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){
			$wpdb->delete( $table_name, array( 'crm_id' => $crm_id));
		}
	}

}

?>