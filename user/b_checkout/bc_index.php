<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);



	if( !session_id()){ session_start();}

	global $wpdb;
    global $wp;

    $cppageUrl =  home_url( $wp->request );
    $siteUrl =  site_url('/');
    $pluginUrl  = WP_PLUGIN_URL . '/trip-booking/';
    $lt_plUrl = site_url('/')."trip-booking/";

    $lt_tyUrl = site_url('/')."thank-you/";

    $n_pluginUrl  = WP_PLUGIN_URL . '/booking-and-checkout/';
    $n_lt_plUrl = site_url('/')."booking-and-checkout/";

    $terms_url = site_url('/');
    $privacy_policy_url = site_url('/');


    //cart list

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	}

	

    //page data start

    if(isset($_GET['page']) && $_GET['page'] == ''){
		echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
		exit();
    }elseif(isset($_GET['page']) && ($_GET['page'] == 'trip-detail') && (isset($_GET['trip'])) && ($_GET['trip'] != "")){
    	$trip_id = $_GET['trip'];
    	$tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';
        $trips = $wpdb->get_row( "SELECT * FROM $tb_trips_tbl where id = '$trip_id' ");
        if(!isset($trips->id)){
            echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
            exit();
        }
        include_once 'trip_detail.php';

    }elseif(isset($_GET['page']) && isset($_GET['trip']) &&  ($_GET['page'] == 'book-trip')){
        $trip_id = $_GET['trip'];
        $tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';
        $trips = $wpdb->get_row( "SELECT * FROM $tb_trips_tbl where id = '$trip_id' ");
        if(!isset($trips->id)){
            echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
            exit();
        }

        if(isset($_POST['tp']) && isset($_POST['Total_Guest_Number']) && isset($_POST['Total_Male']) && isset($_POST['Total_Female'])){

            if(($_POST['Total_Guest_Number'] == 0) || ($_POST['Total_Guest_Number'] != ($_POST['Total_Male'] + $_POST['Total_Female']))){
               
                $_SESSION['msg'] = 'Please Match Correct Number of Guests with Male / Female Selection.';
                $_SESSION['status'] = 'error';
                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=trip-detail&trip='.$_GET['trip'].'");</script>';
                exit();

            }else{
                // echo "<pre>";
                // print_r($_POST);
                $post_data = $_POST;

                $tp = $post_data['tp'];
                if($tp == "2")$p_Option = $post_data['Payment_Option_2'];
                else $p_Option = $post_data['Payment_Option'];

                $post_data['Payment_Option'] = $p_Option;

                $Total_Guest_Number = $post_data['Total_Guest_Number'];
                $pay_amount = 0;
                if($tp == "2"){
                    if($p_Option == "1") $pay_amount = ($trips->Trip_2_Deposit_Amount * $Total_Guest_Number);
                    elseif($p_Option == "2") $pay_amount = ($trips->Trip_2_Total_Price * $Total_Guest_Number);
                    elseif($p_Option == "3") $pay_amount = ($trips->Trip_2_Single_Room_Price * $Total_Guest_Number);
                    else $pay_amount = ($trips->Trip_2_Single_Room_Total_Price * $Total_Guest_Number);

                }else{
                    if($p_Option == "1") $pay_amount = ($trips->Trip_Deposit_Amount * $Total_Guest_Number);
                    elseif($p_Option == "2") $pay_amount = ($trips->Trip_Total_Price * $Total_Guest_Number);
                    elseif($p_Option == "3") $pay_amount = ($trips->Trip_Single_Room_Price * $Total_Guest_Number);
                    else $pay_amount = ($trips->Trip_Single_Room_Total_Price * $Total_Guest_Number);
                }
                include_once 'book_trip.php';
            }

        }else{
            echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
            exit();
        }

        

    }elseif(isset($_GET['page']) && isset($_GET['trip']) &&  $_GET['page'] == 'checkout'){

        if(isset($_POST['stripeToken'])){

            echo "<div  style='width:100%; text-align:center;'><img src='".$pluginUrl."images/payment_process.gif' style='width:30%;'></div>";

            // echo "<pre>";
            // print_r($_POST);
            // exit();

            include_once __DIR__ .'../../../classes/Nzoho.php';
            $Nzoho = new Nzoho;

            if(empty($_POST['First_Name']) || empty($_POST['Last_Name']) || empty($_POST['Email']) || empty($_POST['Phone']) || empty($_POST['Mailing_Country']) || ($_POST['trip_id'] != $_GET['trip']) ){

                $_SESSION['msg'] = 'Please fill up all required field.';
                $_SESSION['status'] = 'error';
                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=trip-detail&trip='.$_GET['trip'].'");</script>';
                exit();
            }

            $trip_id = $_POST['trip_id'];
            $tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';
            $trips = $wpdb->get_row( "SELECT * FROM $tb_trips_tbl where id = '$trip_id' ");
            if(!isset($trips->id)){
                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=trip-detail&trip='.$_GET['trip'].'");</script>';
                exit();
            }

            $contact = save_contact($_POST);
            
            if(isset($contact['crm_id'])){

                $tp = $_POST['tp'];
                $Payment_Option = $_POST['Payment_Option'];
                $Total_Guest_Number = $_POST['Total_Guest_Number'];
                $trip_amount = 0;
                $t_total_amount = 0;

                if($tp == "2"){
                    if($Payment_Option == "1"){
                        $trip_amount = $trips->Trip_2_Deposit_Amount;
                        $t_total_amount = $trips->Trip_2_Total_Price;
                    }
                    elseif($Payment_Option == "2"){
                        $trip_amount = $trips->Trip_2_Total_Price;
                        $t_total_amount = $trips->Trip_2_Total_Price;
                    }
                    elseif($Payment_Option == "3"){
                        $trip_amount = $trips->Trip_2_Single_Room_Price;
                        $t_total_amount = $trips->Trip_2_Single_Room_Total_Price;
                    }
                    else{
                        $trip_amount = $trips->Trip_2_Single_Room_Total_Price;
                        $t_total_amount = $trips->Trip_2_Single_Room_Total_Price;
                    }
                }else{
                    if($Payment_Option == "1"){
                        $trip_amount = $trips->Trip_Deposit_Amount;
                        $t_total_amount = $trips->Trip_Total_Price;
                    }
                    elseif($Payment_Option == "2"){
                        $trip_amount = $trips->Trip_Total_Price;
                        $t_total_amount = $trips->Trip_Total_Price;
                    }
                    elseif($Payment_Option == "3"){
                        $trip_amount = $trips->Trip_Single_Room_Price;
                        $t_total_amount = $trips->Trip_Single_Room_Total_Price;
                    }
                    else{
                        $trip_amount = $trips->Trip_Single_Room_Total_Price;
                        $t_total_amount = $trips->Trip_Single_Room_Total_Price;
                    }
                }




                $charge_amount = ($Total_Guest_Number * $trip_amount);
                $trip_total_amount = ($Total_Guest_Number * $t_total_amount);

                require_once(__DIR__.'../../stripe_lib/vendor/autoload.php');
                \Stripe\Stripe::setApiKey("sk_test_rEOxcWCr6tNxH4U9oxLJxDZ8");
                // \Stripe\Stripe::setApiKey($Stripe->Api_secret);

                $st_charge = \Stripe\Charge::create([
                    "amount" => ($charge_amount*100),
                    "currency" => "USD",
                    "source" => $_POST['stripeToken'], // obtained with Stripe.js
                    "description" => "Charge for ".$_POST['Email']
                ]);

                if(!isset($st_charge->id)){
                    $_SESSION['msg'] = isset($st_charge->failure_message) ? $st_charge->failure_message : 'An Error has occured. Payment not processed. Please try again.';
                    $_SESSION['status'] = 'error';
                    echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=trip-detail&trip='.$_GET['trip'].'");</script>';
                    exit();
                }


                $data_book = $_POST;
                $data_book['charge_amount'] = $charge_amount;
                $data_book['trip_amount'] = $trip_amount;
                $data_book['trip_total_amount'] = $trip_total_amount;
                $data_book['Trip_Name'] = $trips->Trip_Name;
                $data_book['trip_crm_id'] = $trips->crm_id;
                $data_book['trip_id'] = $trips->id;
                $data_book['Payment_Due_Date'] = $trips->Payment_Due_Date;
                $data_book['Trip_Image_Url'] = $trips->Trip_Image_Url;
                $data_book['Trip_Start_Date'] = ($_POST['tp'] == "1") ? $trips->Trip_Start_Date : $trips->Trip_2_Start_Date;
                $data_book['Trip_End_Date'] = ($_POST['tp'] == "1") ? $trips->Trip_End_Date : $trips->Trip_2_End_Date;

                $data_book['stripe_id'] = $st_charge->id;

                $data_book['contact'] = $contact;
                $booking = save_booking($data_book);
                
                $tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';
                
                
                if($tp == "2"){
                    $tp_up['Trip_2_Seat_Booked'] = $seatBooked = ($trips->Trip_2_Seat_Booked != "") ? ($trips->Trip_2_Seat_Booked + $Total_Guest_Number) : $Total_Guest_Number;
                    $z_up['Trip_2_Seat_Booked'] = (string)$seatBooked;

                }else{
                    $z_up['Seat_Booked'] = $tp_up['Seat_Booked'] = ($trips->Seat_Booked != "") ? ($trips->Seat_Booked + $Total_Guest_Number) : $Total_Guest_Number;
                }

                $zcdata_Js = $Nzoho->updateRecords($trips->crm_id, array($z_up), "Products");
            
                $update =  $wpdb->update( $tb_trips_tbl,$tp_up,array( 'id' => $trips->id));
                
                $_SESSION['msg'] = '<h3><strong>Congratulations,</strong><br>Your trip is successfully booked!</h3><div class="clr" style="height: 20px;"></div>
<p style="font-size: 18px;">You will receive a welcome email shortly.  Be sure to check your junk folder (adventures@travr.life).  
Get ready for the time of your life! </p>';
                $_SESSION['status'] = 'success';
                
                echo '<script>window.location.replace("'.$lt_tyUrl.'");</script>';
                exit();
            }else{
                $_SESSION['msg'] = 'An Error has occured. Payment not processed. Please try again.';
                $_SESSION['status'] = 'error';
                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=trip-detail&trip='.$_GET['trip'].'");</script>';
                exit();
            }


        }
        
        echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
        exit();
    }else{
    	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';
		exit();
    }




    function save_contact($post)
    {
        global $wpdb;
        $tablename=$wpdb->prefix.'tb_contacts_tbl';
        $Email = $post['Email'];
        
        $local = $data = array(
            "First_Name" => $post['First_Name'],
            "Last_Name" => $post['Last_Name'],
            "Mailing_Country" => $post['Mailing_Country'],
            "Mailing_Street" => $post['Mailing_Street'],
            "Mailing_City" => $post['Mailing_City'],
            "Mailing_State" => $post['Mailing_State'],
            "Mailing_Zip" => $post['Mailing_Zip'],
            "Phone" => $post['Phone'],
            "Email" => $post['Email'],
            "Gender" => $post['Gender'],
        );

        $zb_ins = array(
            "contact_name" => $post['First_Name']." ".$post['Last_Name'],
            'contact_type'=>'customer',
            'contact_persons'=> array(
                                    array(

                                        'first_name'=> $post['First_Name'],
                                        'last_name'=> $post['Last_Name'],
                                        'email'=> $post['Email'],
                                    )
                                ),
        );

        $local["Company_Name"] = $post['Company_Name'];

        include_once __DIR__ .'../../../classes/ZohoBooks.php';
        $ZohoBooks = new ZohoBooks;

        include_once __DIR__ .'../../../classes/Nzoho.php';
        $Nzoho = new Nzoho;

        $contacts = $wpdb->get_row( "SELECT * FROM $tablename where Email = '$Email' ");
        
        if(isset($contacts->id) && ($contacts->crm_id != "")){

            $zcdata_Js = $Nzoho->updateRecords($contacts->crm_id, array($data), "Contacts");
            $zcdata = json_decode($zcdata_Js);
            
            if(isset($zcdata->data[0]->details->id)){
                $crm_id = $zcdata->data[0]->details->id;
                $local['crm_id'] = $crm_id;
                $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Contacts");
                $local['zoho_data'] = $zcdata_Js;
                
                $update =  $wpdb->update( $tablename,$local,array( 'id' => $contacts->id));
            }
            
        }else{
            $found_con = false;
            
            if( isset($contacts->id) && ($contacts->books_id != "")){
                $b_contact_id = $contacts->books_id;
                $zbdata = $ZohoBooks->getContactById($b_contact_id);
                if(isset($zbdata->contact->zcrm_contact_id)){
                    $local['crm_id'] = $zbdata->contact->zcrm_contact_id;
                    $zcdata_Js = $Nzoho->getRecordsById($zbdata->contact->zcrm_contact_id, "Contacts");
                    $local['zoho_data'] = $zcdata_Js;
                    $local['books_id'] = $b_contact_id;
                    $local['zbooks_data'] = json_encode($zbdata);
                    $update =  $wpdb->update( $tablename,$local,array( 'id' => $contacts->id));
                    $found_con = true;
                } 
            }else{
                $zbdata = $ZohoBooks->getContactByEmail($post['Email']);
                
                if(isset($zbdata->contacts[0])){
                    $b_contact_id = $zbdata->contacts[0]->contact_id;
                    $zbdata = $ZohoBooks->getContactById($b_contact_id);
                    
                    if(isset($zbdata->contact->zcrm_contact_id)){
                        $local['crm_id'] = $zbdata->contact->zcrm_contact_id;
                        $zcdata_Js = $Nzoho->getRecordsById($zbdata->contact->zcrm_contact_id, "Contacts");
                        $local['zoho_data'] = $zcdata_Js;
                        $local['books_id'] = $b_contact_id;
                        $local['zbooks_data'] = json_encode($zbdata);
                        if(isset($contacts->id)){
                            $update =  $wpdb->update( $tablename,$local,array( 'id' => $contacts->id));
                        }else{
                            $insert = $wpdb->insert( $tablename, $local);
                        }
                        $found_con = true;
                    } 
                }
            }

            if(!$found_con){

                $zbdata = $ZohoBooks->createContact($zb_ins);
                
                if(isset($zbdata->contact->contact_id)){
                    $books_id = $zbdata->contact->contact_id;
                    $crm_id = $zbdata->contact->zcrm_contact_id;
                    $zcdata_Js = $Nzoho->updateRecords($crm_id, array($data), "Contacts");
                    $zcdata = json_decode($zcdata_Js);
                    
                    // $crm_id = $zcdata->data[0]->details->id;
                    $local['books_id'] = $books_id;
                    $local['zbooks_data'] = json_encode($zbdata);
                    $local['crm_id'] = $crm_id;
                    $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Contacts");
                    $local['zoho_data'] = $zcdata_Js;
                    
                    $insert = $wpdb->insert( $tablename, $local);
                }else{
                    return array();
                }
            }
        }

        $local['guest_data'] = save_guest_contact($post);
        
        return $local;
    }

    function save_guest_contact($post){
        
        global $wpdb;
        $tablename=$wpdb->prefix.'tb_contacts_tbl';
        $local_guest = array();

        $Guest_Email = isset($post['Guest_Email']) ? $post['Guest_Email'] : array();
        if(count($Guest_Email) > 0){
            foreach ($Guest_Email as $key => $value) {
                $local = array();
                $data = array();
                $Email = $value;
                $local = $data = array(
                    "First_Name" => $post['Guest_First_Name'][$key],
                    "Last_Name" => $post['Guest_Last_Name'][$key],
                    "Phone" => $post['Guest_Phone'][$key],
                    "Gender" => $post['Guest_Gender'][$key],
                    "Email" => $Email,
                );

                $zb_ins = array(
                    "contact_name" => $post['Guest_First_Name'][$key]." ".$post['Guest_Last_Name'][$key],
                    'contact_type'=>'customer',
                    'contact_persons'=> array(
                                            array(

                                                'first_name'=> $post['Guest_First_Name'][$key],
                                                'last_name'=> $post['Guest_Last_Name'][$key],
                                                'email'=> $Email,
                                            )
                                        ),
                );

                include_once __DIR__ .'../../../classes/ZohoBooks.php';
                $ZohoBooks = new ZohoBooks;

                include_once __DIR__ .'../../../classes/Nzoho.php';
                $Nzoho = new Nzoho;

                $contacts = $wpdb->get_row( "SELECT * FROM $tablename where Email = '$Email' ");
                
                if(isset($contacts->id) && ($contacts->crm_id != "")){
                    $zcdata_Js = $Nzoho->updateRecords($contacts->crm_id, array($data), "Contacts");
                    $zcdata = json_decode($zcdata_Js);
                    
                    if(isset($zcdata->data[0]->details->id)){
                        $crm_id = $zcdata->data[0]->details->id;
                        $local['crm_id'] = $crm_id;
                        $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Contacts");
                        $local['zoho_data'] = $zcdata_Js;
                        
                        $update =  $wpdb->update( $tablename,$local,array( 'id' => $contacts->id));
                        
                    }

                }else{
                    $zbdata = $ZohoBooks->createContact($zb_ins);
                   
                    if(isset($zbdata->contact->contact_id)){
                        $books_id = $zbdata->contact->contact_id;
                        $crm_id = $zbdata->contact->zcrm_contact_id;
                        $zcdata_Js = $Nzoho->updateRecords($crm_id, array($data), "Contacts");
                        $zcdata = json_decode($zcdata_Js);
                        
                        // $crm_id = $zcdata->data[0]->details->id;
                        $local['books_id'] = $books_id;
                        $local['zbooks_data'] = json_encode($zbdata);
                        $local['crm_id'] = $crm_id;
                        $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Contacts");
                        $local['zoho_data'] = $zcdata_Js;
                        
                        $insert = $wpdb->insert( $tablename, $local);
                    }

                }//contact create end

                $local_guest[$key] = $local;

            } //foreach end
        }

        return $local_guest;

    }


    function save_booking($post){
        global $wpdb;

        $Email = $post['Email'];
        $c_table=$wpdb->prefix.'tb_contacts_tbl';
        $contactsDt = $wpdb->get_row( "SELECT * FROM $c_table where Email = '$Email' ");

        $tablename=$wpdb->prefix.'tb_booking_tbl';
        
        $local["trip_crm_id"] = $post['trip_crm_id'];
        $local["trip_id"] = $post['trip_id'];
        $local["Trip_Name"] = $post['Trip_Name'];
        $local["contact_crm_id"] = $contactsDt->crm_id;
        $local["contact_id"] = $contactsDt->id;
        $local["First_Name"] = $post['First_Name'];
        $local["Last_Name"] = $post['Last_Name'];
        $local["Gender"]= $post['Gender'];
        $local["Email"]= $post['Email'];
        $local["stripe_id"] = $post['stripe_id'];
        $local["stripeToken"] = $post['stripeToken'];
        $local["Booking_Notes"] = $post['Booking_Notes'];
        
        $data["Total_Guest_Number"] = $local["Total_Guest_Number"] = $post['Total_Guest_Number'];
        $data["Total_Male"] = $local["Total_Male"] = $post['Total_Male'];
        $data["Total_Female"] = $local["Total_Female"] = $post['Total_Female'];
        $data["Trip_Amount"] = $local["Trip_Amount"] = (string)$post['trip_amount'];
        $data["Trip_Paid_Amount"] = $local["Trip_Paid_Amount"] = (string)$post['charge_amount'];
        $data["Trip_Total_Amount"] = $local["Trip_Total_Amount"] = (string)$post['trip_total_amount'];
        $data["Trip_Due_Amount"] = $local["Trip_Due_Amount"] = (string)($post['trip_total_amount'] - $post['charge_amount']);

        $local["Payment_Due_Date"] = $post['Payment_Due_Date'];
        $local["Trip_Start_Date"] = $post['Trip_Start_Date'];
        $local["Trip_End_Date"] = $post['Trip_End_Date'];
        
        $local["Guest_First_Name"] = isset($post['Guest_First_Name']) ? json_encode($post['Guest_First_Name']) : json_encode(array());
        $local["Guest_Last_Name"] = isset($post['Guest_Last_Name']) ? json_encode($post['Guest_Last_Name']) : json_encode(array());
        $local["Guest_Gender"] = isset($post['Guest_Gender']) ? json_encode($post['Guest_Gender']) : json_encode(array());
        $local["Guest_Phone"] = isset($post['Guest_Phone']) ? json_encode($post['Guest_Phone']) : json_encode(array());
        $local["Guest_Email"] = isset($post['Guest_Email']) ? json_encode($post['Guest_Email']) : json_encode(array());
        $local["Trip_Promo_Code"] = $post['Trip_Promo_Code'];
        
        $data["Contact_Name"] = array("id" => $contactsDt->crm_id);
        $data["Trip_Name"] = array("id" => $post['trip_crm_id']);
        $data["Name"] = $post['Trip_Name']." booked by ".$post['First_Name']." ".$post['Last_Name'];

        $Guest_Email = isset($post['Guest_Email']) ? $post['Guest_Email'] : array();
        $Subform_1 = array();$Guest_Crm_Id = array();
        if(count($Guest_Email) > 0){
            foreach ($Guest_Email as $key => $value) {

                $g_con = array();$temp_sub = array();
                $g_con = $wpdb->get_row( "SELECT * FROM $c_table where Email = '$value' ");
                if(isset($g_con->id)){
                    $temp_sub['Guest'] = array("id" => $g_con->crm_id);
                    $temp_sub['Gender'] = $post['Guest_Gender'][$key];
                    $temp_sub['Phone'] = $post['Guest_Phone'][$key];
                    $temp_sub['Email'] = $value;

                    $Subform_1[$key] = $temp_sub;

                    $Guest_Crm_Id[$key] = $g_con->crm_id;
                }

            }
        }

        if(count($Subform_1) >0){
            $data["Subform_1"] = $Subform_1;
            $local["Guest_Crm_Id"] = json_encode($Guest_Crm_Id);
        }

        include_once __DIR__ .'../../../classes/ZohoBooks.php';
        $ZohoBooks = new ZohoBooks;

        include_once __DIR__ .'../../../classes/Nzoho.php';
        $Nzoho = new Nzoho;
        
        $items = array(
            array(
                'product' => array('id' => $post['trip_crm_id']),
                'quantity' => 1,
                'list_price' => $post['trip_total_amount'],
            )
        );
        $zb_ins = array(
            'contact_id' => $contactsDt->books_id,
            'due_date' => $post['Payment_Due_Date'],
            'send' => "true",
            'allow_partial_payments' => "true",
        );

        $zb_inv = $ZohoBooks->createInvoiceInZbook($items, $zb_ins);
        
        if(isset($zb_inv->invoice->invoice_id)){
            $invoice_id = $zb_inv->invoice->invoice_id;
            $invoice_url = $zb_inv->invoice->invoice_url;

            $zb_inv_sent = $ZohoBooks->markSent($invoice_id);

            $local['zbooks_data'] = json_encode($zb_inv);
            $local['books_invoice_id'] = $data["Books_Invoice_ID"] = $invoice_id;
            $local['books_invoice_url'] = $data["Books_Invoice_Url"] = $invoice_url;

            $zb_pay_ins = array(
                'customer_id' => $contactsDt->books_id,
                'payment_mode' => "creditcard",
                'amount' => $post['charge_amount'],
                'date' => date("Y-m-d"),
                'reference_number' => "Credit Card",
                'invoices' => array(
                    array(
                        'invoice_id' => $invoice_id
                    )
                ),
            );
            $zb_pay = $ZohoBooks->createPayment($zb_pay_ins);
            
            $zcdata_Js = $Nzoho->insertRecordsPO(array($data), "Trip_Bookings");
            $zcdata = json_decode($zcdata_Js);
            
            if(isset($zcdata->data[0]->details->id)){
                $Current_Trip_Workflow_DateTime = date("Y-m-d H:i:s");
                
                $crm_id = $zcdata->data[0]->details->id;
                $local['crm_id'] = $crm_id;
                $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Trip_Bookings");
                $local['zoho_data'] = $zcdata_Js;
                
                $insert = $wpdb->insert( $tablename, $local);
                $condata = array();
                if(count($Guest_Crm_Id) > 0){
                    foreach ($Guest_Crm_Id as $key => $value) {
                        $temp_condata = array();
                        $temp_condata['id'] = $value;
                        $temp_condata['Current_Trip'] = array("id" => $post['trip_crm_id']);
                        $temp_condata['Current_Trip_Booking'] = array("id" => $crm_id);
                        $temp_condata['Current_Trip_Start_Date'] = $post['Trip_Start_Date'];
                        $temp_condata['Current_Trip_End_Date'] = $post['Trip_End_Date'];
                        $temp_condata['Current_Trip_Workflow_DateTime'] = $Current_Trip_Workflow_DateTime;
                        $condata[] = $temp_condata;
                    }
                }

                $temp_condata = array();
                $temp_condata['id'] = $contactsDt->crm_id;
                $temp_condata['Current_Trip'] = array("id" => $post['trip_crm_id']);
                $temp_condata['Current_Trip_Booking'] = array("id" => $crm_id);
                $temp_condata['Current_Trip_Start_Date'] = $post['Trip_Start_Date'];
                $temp_condata['Current_Trip_End_Date'] = $post['Trip_End_Date'];
                $temp_condata['Current_Trip_Workflow_DateTime'] = $Current_Trip_Workflow_DateTime;
                $condata[] = $temp_condata;


                $zcdata_Js = $Nzoho->upsertRecords($condata, "Contacts");
                
            }
        
            $local["Trip_Image_Url"] = $post['Trip_Image_Url'];
            // send_email($local);
            

            return $local;
        }else{
            return array();
        }
    }



    function send_email($data){

        $message = '<html>
            <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000; padding:20px;">

                <div style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">

                    <p><b>Hi '.$data['First_Name'].'</b></p>
                    <br>
                    <p>Your trip is booked successfully.</p>
                    <br>
                    <p>Your Trip Details - </p>
                    <div>
                        <table style="width: 670px;">
                            <thead>
                                <tr>
                                    <th style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;">Trip Name</th>
                                    <th style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;">
                                        <img src="'.$data['Trip_Image_Url'].'" style="width:100px; height: 100px;float: left;margin-right: 10px;">

                                        '.$data['Trip_Name'].'<br>'.date("F d, Y", strtotime($data['Trip_Start_Date'])).' - '.date("F d, Y", strtotime($data['Trip_End_Date'])).'

                                    </td>
                                    <td style="text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;">$'.$data['Trip_Paid_Amount'].'</td>
                                </tr>
                                <tr>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;">Subtotal</td>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;" class="nv_t_prc">$'.$data['Trip_Paid_Amount'].'</td>
                                </tr>
                                <tr>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;"><strong>Total</strong></td>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;" class="bold nv_t_prc">$'.$data['Trip_Paid_Amount'].'</td>
                                </tr>
                                <tr>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;"><strong>Due Amount</strong></td>
                                    <td style="height:35px;text-align:left;border-bottom: 2px dashed #eeeeee;padding-left: 15px;" class="bold nv_t_prc">$'.$data['Trip_Due_Amount'].'</td>
                                </tr>';
                            
                            $message .= '</tbody>
                        </table>
                    </div>
                    <br>

                </div>
            </body>
          </html>';

        add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
        // $to      = 'delwarsumon0@gmail.com'; 
        $to      = $data['Email'];
        $subject = 'Trip Booking Confirmation';
        wp_mail( $to, $subject, $message );
        remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
        
    }

    function wpdocs_set_html_mail_content_type() {
        return 'text/html';
    }



?>