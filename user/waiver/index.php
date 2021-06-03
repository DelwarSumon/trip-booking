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



    $n_pluginUrl  = WP_PLUGIN_URL . '/trip-waiver/';

    $n_lt_plUrl = site_url('/')."trip-waiver/";

    $lt_tyUrl = site_url('/')."thank-you/";

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

    }elseif(isset($_GET['page']) && isset($_GET['conid']) &&  ($_GET['page'] == 'waiver') && ($_GET['conid'] != "")){



        $conid = $_GET['conid'];

        // $tb_contacts_tbl=$wpdb->prefix.'tb_contacts_tbl';

        // $contact = $wpdb->get_row( "SELECT * FROM $tb_contacts_tbl where crm_id = '$conid' ");



        include_once __DIR__ .'../../../classes/Nzoho.php';

        $Nzoho = new Nzoho;

        $zcdata_Js = $Nzoho->getRecordsById($conid, "Contacts");

        $zcdata = json_decode($zcdata_Js);

        // echo "<pre>";

        // print_r($zcdata);

        // exit();

        

        if(!isset($zcdata->data[0]) || ($zcdata->data[0]->Current_Trip == "") || ($zcdata->data[0]->Current_Trip_Start_Date == "") || (date("Y-m-d", strtotime($zcdata->data[0]->Current_Trip_Start_Date)) < date("Y-m-d")) ){

            echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

            exit();

        }



        $contact = $zcdata->data[0];

        include_once 'waiver_form.php';



    }elseif(isset($_GET['page']) && isset($_GET['conid']) &&  ($_GET['page'] == 'swaiver') && ($_GET['conid'] != "")){



        if(isset($_POST['conid']) && ($_POST['conid'] == $_GET['conid'])){

            

            $conid = $_POST['conid'];

            $data = $_POST;

            unset($data['conid']);

            include_once __DIR__ .'../../../classes/Nzoho.php';

            $Nzoho = new Nzoho;

            $zcdata_Js = $Nzoho->updateRecords($conid, array($data), "Contacts");

            $zcdata = json_decode($zcdata_Js);

           

            if(isset($zcdata->data[0]->details->id)){

                $_SESSION['msg'] = '<h4>Profile uploaded successfully.  Thank you.</h4>';

                $_SESSION['status'] = 'success';

            }else{

                $_SESSION['msg'] = '<h4>Something went wrong. Try again later.</h4>';

                $_SESSION['status'] = 'error';

            }

            

        }



        echo '<script>window.location.replace("'.$lt_tyUrl.'");</script>';

        exit();



    }else{

    	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

		exit();

    }







?>





