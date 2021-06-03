<?php



/*

Plugin Name:Trip Booking

Plugin URI: 

Description: Trip Booking plugin for wordpress.

Version: 1.0.0



*/





ini_set('display_errors','Off');

ini_set('error_reporting', E_ALL );

define('WP_DEBUG', false);

define('WP_DEBUG_DISPLAY', false);



Class tripClass

{



    function __construct()

    {

        

        if( !session_id()){ session_start();}



        global $wpdb;

        add_action('admin_menu', array($this, 'add_admin_menu'));

    

        add_action( 'admin_post_wp_import_pro', array($this, 'sync_zoho_product'));



        add_action( 'admin_post_wp_add_trip_admin', array($this, 'save_trip'));

        add_action( 'admin_post_delete_lottery', array($this, 'delete_lottery'));

        add_action( 'admin_post_wp_import_demo', array($this, 'import_demo_data'));

  



        //JS

        wp_register_script('prefix_jquery', '//code.jquery.com/jquery-3.4.1.min.js');

        wp_enqueue_script('prefix_jquery');



        wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js');

        wp_enqueue_script('prefix_bootstrap');



        wp_register_script('prefix_jquerydatatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js');

        wp_enqueue_script('prefix_jquerydatatables');



        wp_register_script('prefix_bootstrapdatatables', '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js');

        wp_enqueue_script('prefix_bootstrapdatatables');

        wp_enqueue_script( 'custom_js', plugins_url( '/js/custom_script.js', __FILE__ ), array('jquery', 'jquerydatatables', 'bootstrapdatatables') );

        



        // CSS

        wp_register_style('prefix_bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');

        wp_enqueue_style('prefix_bootstrap_css');

        wp_register_style('prefix_fontawesome', '//use.fontawesome.com/releases/v5.3.1/css/all.css');

        wp_enqueue_style('prefix_fontawesome');



        wp_register_style('prefix_datatables', '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css');

        wp_enqueue_style('prefix_datatables');



        wp_register_style('custom_css', plugins_url( '/css/custom_style.css', __FILE__ ));

        wp_enqueue_style('custom_css');



        //Create Tables

        register_activation_hook( __FILE__, array($this, 'trip_list_tbl'));

        register_activation_hook( __FILE__, array($this, 'trip_booking_tbl'));

        register_activation_hook( __FILE__, array($this, 'trip_contact_tbl'));

        register_activation_hook( __FILE__, array($this, 'zoho_crm_auth_tbl'));

        register_activation_hook( __FILE__, array($this, 'zoho_books_auth_tbl'));

        //Remove table when uninstall plugin

        register_deactivation_hook( __FILE__, array($this, 'plugin_remove_database'));



        // trip list short code

        add_shortcode('TripBooking', array($this, 'tripBookingScode'));

        // Booking & checkout

        add_shortcode('TBBookingCheckout', array($this, 'tripBookingCheckoutScode'));

        // Waiver form

        add_shortcode('TBWaiver', array($this, 'tripBookingWaiverScode'));

        // Partial payment

        add_shortcode('TBPayment', array($this, 'tripBookingPaymentScode'));

        // file upload

        add_shortcode('TBFUpload', array($this, 'tripBookingFUScode'));

        // Thank you

        add_shortcode('TBThankYou', array($this, 'tripBookingTYcode'));

        //crm-webhook

        add_shortcode('TBWebhook', array($this, 'tripBookingCrmWbhkcode'));

        

    }







// =================Create tables on install start===================





    function trip_list_tbl() {

        global $wpdb;



        $table_name = $wpdb->prefix.'tb_trips_tbl';



        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE IF NOT EXISTS $table_name (

                        id int(11) NOT NULL AUTO_INCREMENT,

                        crm_id text DEFAULT NULL,

                        

                        Trip_Name text DEFAULT NULL,

                        Trip_Location text DEFAULT NULL,

                        Trip_Detail_Url text DEFAULT NULL,

                        Trip_Image_Url text DEFAULT NULL,

                        Trip_Description text DEFAULT NULL,



                        Trip_Start_Date date DEFAULT NULL,

                        Trip_End_Date date DEFAULT NULL,

                        Total_Number_of_Seat text DEFAULT NULL,

                        Trip_Total_Price text DEFAULT NULL,

                        Trip_Single_Room_Price text DEFAULT NULL,

                        Trip_Single_Room_Total_Price text DEFAULT NULL,

                        Tier_2_Date text DEFAULT NULL,

                        Tier_2_Increase_Amount text DEFAULT NULL,

                        Tier_3_Date text DEFAULT NULL,

                        Tier_3_Increase_Amount text DEFAULT NULL,

                        Trip_Deposit_Amount text DEFAULT NULL,

                        Payment_Due_Date date DEFAULT NULL,

                        Seat_Booked text DEFAULT NULL,

                        Trip_Included text DEFAULT NULL,
                        Show_Trip_Included text DEFAULT NULL,

                        Trip_Promo_Code text DEFAULT NULL,



                        Trip_2_Start_Date date DEFAULT NULL,

                        Trip_2_End_Date date DEFAULT NULL,

                        Trip_2_Total_Number_of_Seat text DEFAULT NULL,

                        Trip_2_Total_Price text DEFAULT NULL,

                        Trip_2_Single_Room_Price text DEFAULT NULL,

                        Trip_2_Single_Room_Total_Price text DEFAULT NULL,

                        Trip_2_Tier_2_Date text DEFAULT NULL,

                        Trip_2_Tier_2_Increase_Amount text DEFAULT NULL,

                        Trip_2_Tier_3_Date text DEFAULT NULL,

                        Trip_2_Tier_3_Increase_Amount text DEFAULT NULL,

                        Trip_2_Deposit_Amount text DEFAULT NULL,

                        Trip_2_Payment_Due_Date date DEFAULT NULL,

                        Trip_2_Seat_Booked text DEFAULT NULL,

                        Trip_2_Included text DEFAULT NULL,



                        zoho_data mediumtext DEFAULT NULL,

                        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

                        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                        PRIMARY KEY (id)

                    ) $charset_collate;";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );



    }



    function trip_booking_tbl() {

        global $wpdb;



        $table_name = $wpdb->prefix.'tb_booking_tbl';



        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE IF NOT EXISTS $table_name (

                        id int(11) NOT NULL AUTO_INCREMENT,

                        books_invoice_id text DEFAULT NULL,

                        books_invoice_url text DEFAULT NULL,

                        crm_id text DEFAULT NULL,

                        trip_crm_id text DEFAULT NULL,

                        trip_id varchar(20) DEFAULT NULL,

                        Trip_Name text DEFAULT NULL,

                        contact_crm_id text DEFAULT NULL,

                        contact_id varchar(20) DEFAULT NULL,

                        First_Name text DEFAULT NULL,

                        Last_Name text DEFAULT NULL,

                        Gender text DEFAULT NULL,

                        Email text DEFAULT NULL,

                        stripe_id text DEFAULT NULL,

                        stripeToken text DEFAULT NULL,

                        Total_Guest_Number text DEFAULT NULL,

                        Total_Male text DEFAULT NULL,

                        Total_Female text DEFAULT NULL,

                        Trip_Amount text DEFAULT NULL,

                        Trip_Paid_Amount text DEFAULT NULL,

                        Trip_Total_Amount text DEFAULT NULL,

                        Trip_Due_Amount text DEFAULT NULL,

                        Payment_Due_Date date DEFAULT NULL,

                        Trip_Start_Date date DEFAULT NULL,

                        Trip_End_Date date DEFAULT NULL,

                        Booking_Notes text DEFAULT NULL,

                        Guest_Crm_Id text DEFAULT NULL,

                        Guest_First_Name text DEFAULT NULL,

                        Guest_Last_Name text DEFAULT NULL,

                        Guest_Gender text DEFAULT NULL,

                        Guest_Phone text DEFAULT NULL,

                        Guest_Email text DEFAULT NULL,

                        Trip_Promo_Code text DEFAULT NULL,

                        zoho_data mediumtext DEFAULT NULL,

                        zbooks_data mediumtext DEFAULT NULL,

                        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

                        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                        PRIMARY KEY (id)

                    ) $charset_collate;";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );



    }



    function trip_contact_tbl() {

        global $wpdb;



        $table_name = $wpdb->prefix.'tb_contacts_tbl';



        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE IF NOT EXISTS $table_name (

                        id int(11) NOT NULL AUTO_INCREMENT,

                        crm_id text DEFAULT NULL,

                        books_id text DEFAULT NULL,

                        First_Name text DEFAULT NULL,

                        Last_Name text DEFAULT NULL,

                        Company_Name text DEFAULT NULL,

                        Mailing_Country text DEFAULT NULL,

                        Mailing_Street text DEFAULT NULL,

                        Mailing_City text DEFAULT NULL,

                        Mailing_State text DEFAULT NULL,

                        Mailing_Zip text DEFAULT NULL,

                        Phone text DEFAULT NULL,

                        Email text DEFAULT NULL,

                        Gender text DEFAULT NULL,

                        zoho_data mediumtext DEFAULT NULL,

                        zbooks_data mediumtext DEFAULT NULL,

                        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

                        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                        PRIMARY KEY (id)

                    ) $charset_collate;";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );



    }



    function zoho_crm_auth_tbl() {

        global $wpdb;



        $table_name = $wpdb->prefix.'tb_zoho_crm_auth';



        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE IF NOT EXISTS $table_name (

                        id int(11) NOT NULL AUTO_INCREMENT,

                        authorized_client_name text DEFAULT NULL,

                        access_token text DEFAULT NULL,

                        refresh_token text DEFAULT NULL,

                        organization_id text DEFAULT NULL,

                        authorized_redirect_url text DEFAULT NULL,

                        client_id text DEFAULT NULL,

                        client_secret text DEFAULT NULL,

                        code text DEFAULT NULL,

                        create_time text DEFAULT NULL,

                        PRIMARY KEY (id)

                    ) $charset_collate;";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );





        $zoho = array(

            "authorized_client_name" => "WP Plugin Auth",

            "access_token" => "1000.dc022505aba2527de268878424a0002e.bfea0fb6aead8c47e56d26afdc7311c6",

            "refresh_token" => "1000.8a05720020c312df14d859793fe6c31f.9f7bcac666e75aa21071f4e3d2e57f8e",

            "organization_id" => "org703281804",

            "authorized_redirect_url" => "https://accounts.zoho.com",

            "client_id" => "1000.JRVJN2PXRACOG8XQS11VG3UTNTH9JH",

            "client_secret" => "87fb03a44e99b359d0593e61e43005d63cd3ccb094",

            "code" => "1000.d877b718bcf610e4d816d74df3ae39c5.2a636b78056d1ef7104f4ce51f09b704",

            "create_time" => "2020-01-16 05:46:20",

        );



        $insert = $wpdb->insert( $table_name, $zoho);



    }



    function zoho_books_auth_tbl() {

        global $wpdb;



        $table_name = $wpdb->prefix.'tb_zoho_books_auth';



        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE IF NOT EXISTS $table_name (

                        id int(11) NOT NULL AUTO_INCREMENT,

                        authorized_client_name text DEFAULT NULL,

                        access_token text DEFAULT NULL,

                        refresh_token text DEFAULT NULL,

                        organization_id text DEFAULT NULL,

                        authorized_redirect_url text DEFAULT NULL,

                        client_id text DEFAULT NULL,

                        client_secret text DEFAULT NULL,

                        code text DEFAULT NULL,

                        create_time text DEFAULT NULL,

                        PRIMARY KEY (id)

                    ) $charset_collate;";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );



        $zoho = array(

            "authorized_client_name" => "WP Plugin Auth",

            "access_token" => "1000.2d673912090d07feb5e4fd6a32660deb.5e2d72a3601c8654eedcb7111944ad99",

            "refresh_token" => "1000.a268ae66fe40b31860dcfcaf18af3296.32f8f9a1f652fe43810a1f6f6c0f9196",

            "organization_id" => "703699331",

            "authorized_redirect_url" => "https://accounts.zoho.com",

            "client_id" => "1000.JRVJN2PXRACOG8XQS11VG3UTNTH9JH",

            "client_secret" => "87fb03a44e99b359d0593e61e43005d63cd3ccb094",

            "code" => "1000.d877b718bcf610e4d816d74df3ae39c5.2a636b78056d1ef7104f4ce51f09b704",

            "create_time" => "2020-01-16 05:46:20",

        );



        $insert = $wpdb->insert( $table_name, $zoho);



    }





    function sync_zoho_product(){

        global $wpdb;

        include_once 'classes/Nzoho.php';



        $Nzoho = new Nzoho;

        $module = "Products"; 



        $zc_data_page = $Nzoho->getRecordsByPage($module, 1);

        $zc_data_pageArr = json_decode($zc_data_page);

        

        $table_name = $wpdb->prefix."tb_trips_tbl";

        if(isset($zc_data_pageArr->data)){

            $wpdb->query('TRUNCATE TABLE '.$table_name);



            foreach ($zc_data_pageArr->data as $key => $value) {

                $id = $value->id;

                if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){

                    $this->saveDataToDb($table_name,$value);

                }else{ echo $table_name."  table is not existis."; }  



            }

        }



        $url = site_url().'/wp-admin/admin.php?page=trip-booking';

        wp_redirect( $url );

        exit;

        

    }



    function saveDataToDb($table_name,$data)

    {

        global $wpdb;

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

        

        // $local['Trip_Included'] = '["Travel Host","Hotel & Accommodations","City to City Transfers","Activity Transfers","Welcome & Farewell Dinner","All Breakfasts","Itinerary Activities","Welcome Gift Boxes"]';

        $insert = $wpdb->insert( $table_name, $local);

    }



    



// =================Create tables on install end ===================





// ================= Delete tables on deactivate start===================



    function plugin_remove_database() {

        global $wpdb;



        $trips_tbl=$wpdb->prefix.'tb_trips_tbl';

        $sql_1 = "DROP TABLE IF EXISTS $trips_tbl";



        $tb_contacts_tbl=$wpdb->prefix.'tb_contacts_tbl';

        $sql_4 = "DROP TABLE IF EXISTS $tb_contacts_tbl";



        $tb_booking_tbl=$wpdb->prefix.'tb_booking_tbl';

        $sql_5 = "DROP TABLE IF EXISTS $tb_booking_tbl";





        $tb_zoho_crm_auth=$wpdb->prefix.'tb_zoho_crm_auth';

        $sql_2 = "DROP TABLE IF EXISTS $tb_zoho_crm_auth";

        $tb_zoho_books_auth=$wpdb->prefix.'tb_zoho_books_auth';

        $sql_3 = "DROP TABLE IF EXISTS $tb_zoho_books_auth";



        $wpdb->query($sql_1);

        $wpdb->query($sql_4);

        $wpdb->query($sql_5);



        $wpdb->query($sql_2);

        $wpdb->query($sql_3);

        delete_option("my_plugin_db_version");

    }

// ================= Delete tables on deactivate end===================





// =================insert data start===================





    public function save_trip()

    {   

        if(session_id() == ''){ session_start(); }



        if ( isset( $_POST['submit'] ) ){



            global $wpdb;



            $tablename=$wpdb->prefix.'tb_trips_tbl';



            $local = $data = $_POST;

            unset($data['action']);

            unset($data['submit']);

            // unset($data['Trip_Included']);

            // unset($data['Trip_2_Included']);

            unset($data['Trip_Promo_Code']);

            $local = $data;

            $local['Trip_Included'] = json_encode($_POST['Trip_Included']);

            // $local['Trip_2_Included'] = json_encode($_POST['Trip_2_Included']);

            $local['Trip_Promo_Code'] = $_POST['Trip_Promo_Code'];

            $data['Product_Name'] = $_POST['Trip_Name'];

            unset($data['Trip_Name']);



            // echo "<pre>";

            // print_r($local);

            // print_r($data);

            // exit();



            include_once 'classes/Nzoho.php';

            $Nzoho = new Nzoho;

            $zcdata_Js = $Nzoho->insertRecordsPO(array($data), "Products");

            $zcdata = json_decode($zcdata_Js);

            // print_r($zcdata);
            

            if(isset($zcdata->data[0]->details->id)){

                $crm_id = $zcdata->data[0]->details->id;

                $local['crm_id'] = $crm_id;

                $zcdata_Js = $Nzoho->getRecordsById($crm_id, "Products");

                $zc_data_pageArr = json_decode($zcdata_Js);

                if(isset($zc_data_pageArr->data[0]))$local['zoho_data'] = json_encode($zc_data_pageArr->data[0]);

                

                $insert = $wpdb->insert( $tablename, $local);

            

                $_SESSION['msg'] = 'Successfully Added';

                $_SESSION['status'] = 'success';

                $_SESSION['tab'] = 'AddTrip_Admin';

                

            }else{

                $_SESSION['msg'] = (isset($zcdata->data[0]->message)) ? $zcdata->data[0]->message : 'An Error has occured';

                $_SESSION['status'] = 'error';

                $_SESSION['tab'] = 'AddTrip_Admin';

            }



        }else if ( isset( $_POST['update'] ) ){



            global $wpdb;



            $tablename=$wpdb->prefix.'tb_trips_tbl';



            $local = $data = $_POST;

            unset($data['action']);

            unset($data['submit']);

            $local = $data;

            $data['Name'] = $_POST['Trip_Name'];

            unset($data['Trip_Name']);



            echo "<pre>"; print_r($data); exit();



            // $update =  $wpdb->update( $tablename,$data,array( 'id' => $_POST['idd']));



            if(session_id() == ''){ session_start(); }

            if($update)

            {

                $_SESSION['msg'] = 'Successfully Updated';

                $_SESSION['status'] = 'success';

                $_SESSION['tab'] = 'AddLottery_Admin';



            }else{

                $_SESSION['msg'] = 'An Error has occured';

                $_SESSION['status'] = 'error';

                $_SESSION['tab'] = 'AddLottery_Admin';

            }

        }



        $url = site_url().'/wp-admin/admin.php?page=trip-booking';

        wp_redirect( $url );

        exit;



    }



    





    public function import_demo_data()

    {

        global $wpdb;

        $this->import_demo_lottery();

        $this->import_demo_price_group();

        $this->import_demo_quiz();



        $_SESSION['msg'] = 'Data imported successfully.';

        $_SESSION['status'] = 'success';   



        $url = site_url().'/wp-admin/admin.php?page=lottery';

        wp_redirect( $url );

        exit;

    }



    function import_demo_lottery(){

        global $wpdb;

        $lt_lottery_tbl=$wpdb->prefix.'lt_lottery_tbl';

        $lottery = array(

            "Lottery_Name" => "ROLEX PEPSI",

            "Lottery_Type" => "BONUS MINI-COMPETITION",

            "Summary" => "Winner will receive 10 additional tickets for the Rolex Pepsi Competition. You’ll automatically be entered into the draw upon purchasing your ticket.",

            "Image" => "",

            "Lottery_Description" => "Enter for a chance to win the Rolex GMT-Master II Pepsi reference 126710BLRO. This sought after watch will be delivered to the winner complete with box, papers and manufacture guarantee.",

            "Start_Date_time" => date("Y-m-d H:i:s"),

            "End_Date_time" => date("Y-m-d H:i:s", strtotime('+15 days')),

            "Max_Ticket" => 400,

            "Worth" => 15000,

            "First_Price" => "",

            "Second_Price" => "",

            "Third_Price" => "",

        );



        $insert = $wpdb->insert( $lt_lottery_tbl, $lottery);



    }



    function import_demo_price_group(){

        global $wpdb;

        $tablename = $wpdb->prefix.'lt_price_group_tbl';



        $data = array(

            array(

                "Entry_Title" => "1 entry",

                "Entry_Quantity" => 1,

                "Price" => 30,

                "Description" => "1 Ticket to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 0,

                "Chance_of_winning" => "",

            ),

            array(

                "Entry_Title" => "2 entries",

                "Entry_Quantity" => 2,

                "Price" => 60,

                "Description" => "2 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 0,

                "Chance_of_winning" => "",

            ),

            array(

                "Entry_Title" => "3 entries",

                "Entry_Quantity" => 3,

                "Price" => 90,

                "Description" => "3 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 0,

                "Chance_of_winning" => "",

            ),

            array(

                "Entry_Title" => "4 entries",

                "Entry_Quantity" => 4,

                "Price" => 120,

                "Description" => "4 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 0,

                "Chance_of_winning" => "",

            ),

            array(

                "Entry_Title" => "5 entries",

                "Entry_Quantity" => 5,

                "Price" => 150,

                "Description" => "5 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 10,

                "Chance_of_winning" => "1:200",

            ),

            array(

                "Entry_Title" => "10 entries",

                "Entry_Quantity" => 10,

                "Price" => 300,

                "Description" => "10 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 30,

                "Chance_of_winning" => "1:100",

            ),

            array(

                "Entry_Title" => "20 entries",

                "Entry_Quantity" => 20,

                "Price" => 600,

                "Description" => "20 Tickets to compete for a Rolex GMT Master II Pepsi",

                "Discount" => 80,

                "Chance_of_winning" => "1:50",

            ),

        );



        foreach ($data as $key => $value) {

            $insert = $wpdb->insert( $tablename, $value);

        }



    }



    function import_demo_quiz(){

        global $wpdb;

        $tablename=$wpdb->prefix.'lt_quiz_tbl';

        $data = array(

            "Quiz_Title" => "Which iconic watch model is pictured here?",

            "Image" => "http://novicesolutions.com/projects/lottery_new/wp-content/uploads/2019/10/quiz1.png",

            "Option_Multiple" => json_encode(array("Datejust","Sky-Dweller","Explorer","Submariner","Daytona","Santos","Air-King","Milgauss")),

            "Answer" => "Datejust",

            "Description" => "Select the correct answer to be entered into the final draw. Your answer will apply to all your tickets. The final draw will be streamed live on our Instagram. End of competition: 8th of October 2019.",

        );

        $insert = $wpdb->insert( $tablename, $data);



    }





// =================Insert data end===================





// =================Delete data start===================





    public function delete_lottery()

    {

        global $wpdb;

        



        $tablename=$wpdb->prefix.'lt_lottery_tbl';

        $delete = $wpdb->delete( $tablename, array( 'id' => $_POST['idd']));



        if(session_id() == ''){ session_start(); }

        if($delete)

        {

            $_SESSION['msg'] = 'Lottery deleted successfully.';

            $_SESSION['status'] = 'success';

        }

        

        else

        {

            $_SESSION['msg'] = 'An Error has occured';

            $_SESSION['status'] = 'error';

        }



      

        $url = site_url().'/wp-admin/admin.php?page=lottery';

        wp_redirect( $url );

        exit;



    }









// =================Delete data end==================================



// =====================Add admin menu start===================



   

    public function add_admin_menu()

    {



        $page_title = 'Trip Booking';

        $menu_title = 'Trip Booking';

        $capability = 'manage_options';



        $menu_slug = 'trip-booking';

        $icon_url = 'dashicons-image-filter';

        $position = 7;



        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'trip_booking_admin'), $icon_url, $position);

        

    }





// =====================Add admin menu end===================



// =======================Select data from table start===========================



    public function trip_booking_admin(){

        if(session_id() == ''){ session_start(); } 

        

        global $wpdb;



        $tb_trips_tbl=$wpdb->prefix.'tb_trips_tbl';



        $results = $wpdb->get_results("SELECT * FROM $tb_trips_tbl");

        

        include_once 'admin/trip_booking_admin.php';



    }





// =======================Select data from table end===========================





// =======================Short codes start===========================



    public function tripBookingScode($attr = ""){

        ob_start();

        include_once 'user/index.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingCheckoutScode($attr = ""){

        ob_start();

        include_once 'user/b_checkout/bc_index.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingPaymentScode($attr = ""){

        ob_start();

        include_once 'user/s_pages/take_payment.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingWaiverScode($attr = ""){

        ob_start();

        include_once 'user/waiver/index.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingFUScode($attr = ""){

        ob_start();

        include_once 'user/file_upload/fu_index.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingTYcode($attr = ""){

        ob_start();

        include_once 'user/thankyou/thank_you.php';

        $contents = ob_get_clean();

        return $contents; 

    }





    public function tripBookingCrmWbhkcode($attr = ""){

        ob_start();

        include_once 'user/tb_webhook.php';

        $contents = ob_get_clean();

        return $contents; 

    }







// =======================Short codes end===========================



}



$load = new tripClass();