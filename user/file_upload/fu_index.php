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



    $n_pluginUrl  = WP_PLUGIN_URL . '/media-upload/';

    $n_lt_plUrl = site_url('/')."media-upload/";



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

    }elseif(isset($_GET['page']) && isset($_GET['conid']) &&  ($_GET['page'] == 'passport') && ($_GET['conid'] != "")){



        $conid = $_GET['conid'];

        $tb_contacts_tbl=$wpdb->prefix.'tb_contacts_tbl';

        $contact = $wpdb->get_row( "SELECT * FROM $tb_contacts_tbl where crm_id = '$conid' ");

        $show_label = "Photo";

        $show_heading = "<h3>Passport <strong>Upload</strong></h3>";

        if(isset($contact->id)){

        	include_once 'media_upload.php';

        }else{

        	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

			exit();

        }



    }elseif(isset($_GET['page']) && isset($_GET['conid']) &&  ($_GET['page'] == 'fileupload') && ($_GET['conid'] != "")){



        $conid = $_GET['conid'];

        $tb_contacts_tbl=$wpdb->prefix.'tb_contacts_tbl';

        $contact = $wpdb->get_row( "SELECT * FROM $tb_contacts_tbl where crm_id = '$conid' ");

        $show_label = "Photo";

        $show_heading = "<h3>Media <strong>Upload</strong></h3>";

        if(isset($contact->id)){

        	include_once 'media_upload.php';

        }else{

        	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

			exit();

        }



    }elseif(isset($_GET['page']) && isset($_GET['conid']) &&  ($_GET['page'] == 'upfile') && ($_GET['conid'] != "")){



        if(isset($_POST['conid']) && ($_POST['conid'] == $_GET['conid']) && isset($_FILES["md_upload"]["tmp_name"])){

            

            $file = $_FILES["md_upload"]["tmp_name"];

            $target_dir = __DIR__ ."/temp_media/";

			$content = $target_dir . basename($_FILES["md_upload"]["name"]);

        	move_uploaded_file($file, $content);



            $conid = $_POST['conid'];

            $data = $_POST;

            unset($data['conid']);

            include_once __DIR__ .'../../../classes/Nzoho.php';

            $Nzoho = new Nzoho;

            $zcdata_Js = $Nzoho->uploadFile("Contacts", $content, $conid);

            $zcdata = json_decode($zcdata_Js);

            if(file_exists($content)){

            	unlink($content);

            }

            if(isset($zcdata->data[0]->details->id)){

                $_SESSION['msg'] = '<h3>File Uploaded Successfully, Thank You.</h3>';

                $_SESSION['status'] = 'success';



                echo '<script>window.location.replace("'.$lt_tyUrl.'");</script>';

                exit();

            }else{

                $_SESSION['msg'] = 'Something went wrong. Try again later.';

                $_SESSION['status'] = 'error';

            }



        }



        echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

        exit();

    }else{

    	echo '<script>window.location.replace("'.$lt_plUrl.'");</script>';

		exit();

    }







?>

