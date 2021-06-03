<?php
/**
*** @12/09/2018 by Softanis
*** @sorfuddin@gmail.com
*** @tutorial: Zoho Books API management class
*** @method:https://www.zoho.com/books/api/v3/invoices/#create-an-invoice
**/

class ZohoBooks 
{
   
	protected $authToken;

    public $scope = 'ZohoBooks/booksapi';
    public $organization_id = '703699331';
    public $url = 'https://books.zoho.com/api/v3/';
	public $newFormat = 1;

    public function __construct($authtoken = '')
	{
		$this->authToken = $authtoken; 
		global $wpdb;
        
        $tb_zoho_books_auth = $wpdb->prefix.'tb_zoho_books_auth';
        $auth_data = $wpdb->get_row("SELECT * FROM $tb_zoho_books_auth ORDER BY id DESC");

		$this->authToken = 'Zoho-oauthtoken '.$auth_data->access_token;   
		$this->organization_id = $auth_data->organization_id;   

		$db_time_with_increase_time = date('Y-m-d H:i:s', strtotime("+59 minutes", strtotime($auth_data->create_time)));
		$dtA = strtotime($db_time_with_increase_time);
        $dtB = strtotime(date('Y-m-d H:i:s'));
        

		if ( $dtA < $dtB ) {
			$insArr['refresh_token'] = $data['refresh_token'] = $auth_data->refresh_token;
			$insArr['client_id'] = $data['client_id'] = $auth_data->client_id;
			$insArr['client_secret'] = $data['client_secret'] =$auth_data->client_secret;
			$data['grant_type'] = 'refresh_token';

		  	$token_data = $this->refresh_authtoken($data);
			$token_dataArr = json_decode($token_data);

			if(isset($token_dataArr->access_token)) $this->authToken = 'Zoho-oauthtoken '.$token_dataArr->access_token;

			$insArr['access_token'] = $token_dataArr->access_token;
			$insArr['authorized_client_name'] = $auth_data->authorized_client_name;
			$insArr['code'] = $auth_data->code;
			$insArr['create_time'] = date('Y-m-d H:i:s');
 			$insArr['organization_id'] = $auth_data->organization_id;
            $insArr['authorized_redirect_url'] = $auth_data->authorized_redirect_url;
            
 			$wpdb->insert( $tb_zoho_books_auth, $insArr);
		}
	}

	function refresh_authtoken($data){

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://accounts.zoho.com/oauth/v2/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"refresh_token\"\r\n\r\n".$data['refresh_token']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_id\"\r\n\r\n".$data['client_id']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_secret\"\r\n\r\n".$data['client_secret']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\n".$data['grant_type']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return $err;
		} else {
		  return $response;
		}

	}

	/*------------------------------------------------------------------------------
	--------------------------------------------------------------------------------
		GET Functions Here
	--------------------------------------------------------------------------------
	--------------------------------------------------------------------------------*/

	function getInvoiceByinvId($Id)
	{
		$url = $this->url.'invoices/'.$Id.'?organization_id='.$this->organization_id.'&';
		$result = $this->get_from_books($url);

		$inv_object = json_decode($result);
		
		$return_result = (isset($inv_object->invoice)) ? $inv_object->invoice : array();

		return $return_result;
		
	}

	
	function getContactByZcrmAccountId($zcrm_account_id)
	{
		$params = $this->prepareParameters(array(
			'zcrm_account_id'=>$zcrm_account_id
		));

		$url = $this->url.'contacts?'.$params;
		$result = $this->get_from_books( $url);
		$contact_object = json_decode($result);
		$contacts = $contact_object->contacts;
		$contact = (count($contacts)>0) ? $contacts[0] : false;

		return $contact;
	}

	
	function getContactByEmail($email)
	{
		$params = $this->prepareParameters(array(
			'email'=>$email
		));

		$url = $this->url.'contacts?'.$params;
		$result = $this->get_from_books( $url);
		$contact_object = json_decode($result);
		
		return $contact_object;
	}

	public function getContactById($contact_id){
		$url = $this->url.'contacts/'.$contact_id.'?organization_id='.$this->organization_id.'&';
		$result = $this->get_from_books( $url);
		$contact_object = json_decode($result);
		
		return $contact_object;

	}

	function getItemIdByCrmProductId($crm_product_id)
	{
		$params = $this->prepareParameters(array(
			'zcrm_product_id'=> $crm_product_id
		));

		$url = $this->url.'items?organization_id='.$this->organization_id.'&'.$params;
        $result = $this->get_from_books($url);
        $item_object = json_decode($result);
        
        $items = isset($item_object->items) ? $item_object->items : array();
        $item = (count($items)>0) ? $items[0] : false;

        return $item;
	}




	/*------------------------------------------------------------------------------
	--------------------------------------------------------------------------------
		GET Curl
	--------------------------------------------------------------------------------
	--------------------------------------------------------------------------------*/
	function get_from_books($url) {
		if($this->authToken == '' || $this->organization_id == ''){
			return false; 
		}
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: ".$this->authToken
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return $err;
		} else {
		  return $response;
		}
	}



	/*------------------------------------------------------------------------------
	--------------------------------------------------------------------------------
		POST Functions Here
	--------------------------------------------------------------------------------
	--------------------------------------------------------------------------------*/
	function createContact($contact_array){

		$jsonpost = json_encode($contact_array);
		$post['JSONString'] = $jsonpost;	
        
		$url = $this->url.'contacts?organization_id='.$this->organization_id;
		$result = $this->post_to_books( $url, $post);
		//echo "<pre>"; print_r(json_decode($result)); echo "</pre>";exit();
		return json_decode($result);
	}

	/*------------------------------------------------------------------------------
		Invoice create
	--------------------------------------------------------------------------------*/

	function createInvoiceInZbook($items,$post_data){
		
		$jsonpost = $this->prepareInvoiceData($items,$post_data);
		$post['JSONString'] = $jsonpost;	
        
		$url = $this->url.'invoices?organization_id='.$this->organization_id;
		$result = $this->post_to_books( $url, $post);
		//echo "<pre>"; print_r(json_decode($result)); echo "</pre>";exit();
		return json_decode($result);
	}

	function prepareInvoiceData($items,$post_data){
		$contact_id = $post_data['contact_id'];

		$line_items = $this->prepareLineItemsForInvoice($items);        
        $date = date('Y-m-d');
        $due_date = $post_data['due_date'];


        $book_invoice_data_array = array(
            'customer_id'=>$contact_id,
            'date'=>$date,
            'due_date' => $due_date,
            'is_discount_before_tax'=>true,
            'discount_type'=>'item_level',
            'is_inclusive_tax'=>false,
            // 'salesperson_name'=>'Test',
            'line_items'=>$line_items,
            'allow_partial_payments'=>true,
            'terms'=>'Terms and conditions apply.',
        );

		// echo "<pre>"; print_r($book_invoice_data_array); echo "</pre>";//exit();
        $book_invoice_data_json = json_encode($book_invoice_data_array);

		return $book_invoice_data_json;
	}
	

    /*------------------------------------------------------------------------------
		Create Payment of invoice
	--------------------------------------------------------------------------------*/
    function createPayment($post_data){

		$post['JSONString'] = json_encode($post_data);
		$url = $this->url.'customerpayments?organization_id='.$this->organization_id.'&';
		$result = $this->post_to_books($url, $post);
		$result = json_decode($result);
		return $result;
	}

	function markSent($invoice_id){
		$url = $this->url.'invoices/'.$invoice_id.'/status/sent?organization_id='.$this->organization_id.'&';
		$result = $this->post_to_books($url, array());
		$result = json_decode($result);
		return $result;
	}



	/*------------------------------------------------------------------------------
		Post Curl Here
	--------------------------------------------------------------------------------*/
	function post_to_books($url, $fields){
		$authtoken = $this->authToken;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => http_build_query($fields),
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: ".$authtoken,
		    "content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		$info = curl_getinfo($curl); 
		//echo '<pre>';print_r($info);echo '</pre>'; 

		curl_close($curl);

		if ($err) {
		  return $err;
		} else {
		  return $response;
		}

	}

	/*------------------------------------------------------------------------------
		Common Functions Here
	--------------------------------------------------------------------------------*/

	function prepareLineItemsForInvoice($crm_products)
	{
		$line_items = array();
		foreach ($crm_products as $product)
		{
			$item = $this->getItemIdByCrmProductId($product['product']['id']);
			$line_item = array();
			if($item){
	            $line_item = array(
	                'item_id'=> $item->item_id,
	                'quantity'=>$product['quantity'],
	                'rate'=>$product['list_price']
	            );
	          
            }

            $line_items[] = $line_item;
        }
	
        return $line_items;
	}


	// Set input parameters for the Zoho API request
    private function prepareParameters($extra = array())
    {
        $parameters['scope'] = $this->scope;

        if(!empty($extra))
            $parameters = array_merge($parameters, $extra);

        $string = '';
        foreach($parameters as $key => $val) {
            $string .= "$key=".urlencode($val).'&';
        }

        return trim($string, '&');
    }



    



   
}
