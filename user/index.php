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
    $lt_pl_dtlUrl = site_url('/')."booking-and-checkout/";

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
    }else{

        $tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';
        $trips = $wpdb->get_results( "SELECT * FROM $tb_trips_tbl order by id desc");
        include_once 'dashboard.php';

    }





?>

