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



    $n_pluginUrl  = WP_PLUGIN_URL . '/give-payment/';

    $n_lt_plUrl = site_url('/')."give-payment/";



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

    }elseif(isset($_GET['page']) && isset($_GET['booking']) &&  ($_GET['page'] == 'ptake') && ($_GET['booking'] != "")){



        $booking_id = $_GET['booking'];

        $tb_booking_tbl=$wpdb->prefix.'tb_booking_tbl';

        $booking = $wpdb->get_row( "SELECT * FROM $tb_booking_tbl where crm_id = '$booking_id' ");

        

        if(!isset($booking->id) || ($booking->Trip_Total_Amount <1) || ($booking->Trip_Paid_Amount == $booking->Trip_Total_Amount)){

            echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

            exit();

        }

        $trip_id = $booking->trip_id;

        $tb_trips_tbl = $wpdb->prefix.'tb_trips_tbl';

        $trips = $wpdb->get_row( "SELECT * FROM $tb_trips_tbl where id = '$trip_id' ");



        include_once 'take_rest_payment.php';



    }elseif(isset($_GET['page']) && isset($_GET['booking']) &&  ($_GET['page'] == 'stake') && ($_GET['booking'] != "")){



        if(isset($_POST['stripeToken'])){



            echo "<div  style='width:100%; text-align:center;'><img src='".$pluginUrl."images/payment_process.gif' style='width:30%;'></div>";



            if(empty($_POST['booked_id']) || empty($_POST['take_amount']) || ($_POST['take_amount'] < 1) || ($_POST['booked_id'] != $_GET['booking']) ){



                $_SESSION['msg'] = 'Something went wrong. Please try again.';

                $_SESSION['status'] = 'error';

                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=ptake&booking='.$_GET['booking'].'");</script>';

                exit();

            }



            $booking_id = $_POST['booked_id'];

            $tb_booking_tbl=$wpdb->prefix.'tb_booking_tbl';

            $booking = $wpdb->get_row( "SELECT * FROM $tb_booking_tbl where crm_id = '$booking_id' ");

            

            if(!isset($booking->id) || ($booking->Trip_Total_Amount <1) || ($booking->Trip_Paid_Amount == $booking->Trip_Total_Amount)){

                echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

                exit();

            }



            require_once(__DIR__.'../../stripe_lib/vendor/autoload.php');

            \Stripe\Stripe::setApiKey("sk_test_rEOxcWCr6tNxH4U9oxLJxDZ8");

            // \Stripe\Stripe::setApiKey($Stripe->Api_secret);



            $take_amount = $_POST['take_amount'];

            $st_charge = \Stripe\Charge::create([

                "amount" => ($take_amount*100),

                "currency" => "USD",

                "source" => $_POST['stripeToken'], // obtained with Stripe.js

                "description" => "Charge for ".$booking->Email

            ]);



            if(!isset($st_charge->id)){

                $_SESSION['msg'] = isset($st_charge->failure_message) ? $st_charge->failure_message : 'An Error has occured. Payment not processed. Please try again.';

                $_SESSION['status'] = 'error';

                echo '<script>window.location.replace("'.$n_lt_plUrl.'?page=ptake&booking='.$_GET['booking'].'");</script>';

                exit();

            }



            include_once __DIR__ .'../../../classes/Nzoho.php';

            $Nzoho = new Nzoho;



            include_once __DIR__ .'../../../classes/ZohoBooks.php';

            $ZohoBooks = new ZohoBooks;



            $d_crm = array();



            $contact_crm_id = $booking->contact_crm_id;

            $tb_contacts_tbl=$wpdb->prefix.'tb_contacts_tbl';

            $contactsDt = $wpdb->get_row( "SELECT * FROM $tb_contacts_tbl where crm_id = '$contact_crm_id' ");



            // books payment

            $zb_pay_ins = array(

                'customer_id' => $contactsDt->books_id,

                'payment_mode' => "creditcard",

                'amount' => $take_amount,

                'date' => date("Y-m-d"),

                'reference_number' => "Credit Card",

                'invoices' => array(

                    array(

                        'invoice_id' => $booking->books_invoice_id

                    )

                ),

            );

            $zb_pay = $ZohoBooks->createPayment($zb_pay_ins);



            $d_crm['Trip_Paid_Amount'] = (string)($booking->Trip_Paid_Amount + $take_amount);

            $d_crm['Trip_Due_Amount'] = (string)($booking->Trip_Due_Amount - $take_amount);

            

            $zcdata_Js = $Nzoho->updateRecords($booking_id, array($d_crm), "Trip_Bookings");

            $zcdata = json_decode($zcdata_Js);

            if(isset($zcdata->data[0]->details->id)){

                $update =  $wpdb->update( $tb_booking_tbl, $d_crm, array( 'id' => $booking->id));

            }

            



            $_SESSION['msg'] = '<h3>Payment Successful, Thank You!</h3>';

            $_SESSION['status'] = 'success';



            echo '<script>window.location.replace("'.$lt_tyUrl.'");</script>';

            exit();

        }



        echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

        exit();





    }else{

    	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

		exit();

    }







?>

