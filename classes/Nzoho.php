<?php
class Nzoho

{
	private $authtoken;
	private $newFormat;
	private $error;
	private $code;
	private $msg;
	
	public function __construct($authtoken = '')
	{
		@session_start();
    	
    	global $wpdb;
        
        $tb_zoho_crm_auth = $wpdb->prefix.'tb_zoho_crm_auth';
        $auth_data = $wpdb->get_row("SELECT * FROM $tb_zoho_crm_auth ORDER BY id DESC");

		$this->authtoken = 'Zoho-oauthtoken '.$auth_data->access_token;   

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

			if(isset($token_dataArr->access_token)) $this->authtoken = 'Zoho-oauthtoken '.$token_dataArr->access_token;

			$insArr['access_token'] = $token_dataArr->access_token;
			$insArr['authorized_client_name'] = $auth_data->authorized_client_name;
			$insArr['code'] = $auth_data->code;
			$insArr['create_time'] = date('Y-m-d H:i:s');
 			$insArr['organization_id'] = $auth_data->organization_id;
            $insArr['authorized_redirect_url'] = $auth_data->authorized_redirect_url;
            
 			$wpdb->insert( $tb_zoho_crm_auth, $insArr);
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

	public function getRecordsById($id, $module)
	{
		if (!$id) return false;
		try
		{
			$records = array();
			$resultAr = array();
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module/$id";
			$result = $this->get_from_zoho($zoho_url);
			return $result;
		}catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}


	public function getRecordsByPage($module, $page = 1)
	{
		try
		{
			$sortColumn = 'Modified_Time';
			$selectColumns = array();
			$sortBy = 'asc';
			$maxRecords = 200;
			$post = array();
			$hasMore = true;
			$records = array();

			$url = "https://www.zohoapis.com/crm/v2/$module";
			
			if (count($selectColumns)) $selectColumns = implode(',', $selectColumns);
			$post['fields'] = $selectColumns;
			$post['sort_order'] = 'desc';
			$post['sort_by'] = $sortColumn;
			$post['page'] = $page;
			$post['per_page'] = 200;
			
			$fields_string = http_build_query($post, '', "&");
			$zoho_url = $url . "?$fields_string";

			$result = $this->get_from_zoho($zoho_url);
			return $result;
				
		}

		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}


	
	private function get_from_zoho($url){
		
		$authtoken = $this->authtoken;
		
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
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: ".$authtoken
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  return $response;
		}

	}

	public function insertRecords($data = array() , $module, $wfTrigger = 'true', $isApproval = 'false', $duplicateCheck = 2)
	{
		try
		{
			$post = $this->makeJson($data);
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module";
			$result = $this->post_to_zoho($zoho_url, $post);
			return $result;
		}
		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}

	public function insertRecordsPO($data, $module){
		try
		{
			$jsonpost = json_encode($data);
			$post = '{"data": '.$jsonpost.',"trigger": ["workflow"]}';
			
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module";
			$result = $this->post_to_zoho($zoho_url, $post);
			return $result;
		}
		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}

	function makeJson($data){
		$str = '';
		foreach ($data as $key => $value) {
			$post = json_encode($value, JSON_FORCE_OBJECT);
    		$str .= $post.',';
		}
		$strtrim = rtrim($str,',');
		$post = '{"data": ['.$strtrim.'],"trigger": ["workflow"]}';

		return $post;
	}

	function post_to_zoho($zoho_url, $fields){
		
		$authtoken = $this->authtoken;

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $zoho_url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		$headers = array(); 
		$headers[] = "Authorization: ".$authtoken; 
		$headers[] = "Content-Type: application/json"; 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		
		$response = curl_exec($ch); 
		$err = curl_errno($ch);
		
		curl_close ($ch);
		if ($err) {
		  return $err;
		} else {
		  return $response;
		}
	}


	public function updateRecords($id,$data = array() , $module, $wfTrigger = 'false')
	{
		try
		{
			$post = array();
			$data[0]['id'] = $id;

			$post = $this->makeJson($data);
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module";

			$result = $this->update_to_zoho($zoho_url, $post);
			return $result;
		}

		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}

	public function upsertRecords($data = array() , $module, $wfTrigger = ""){
		try
		{
			$post = array();
			$post = $this->makeJson($data, $wfTrigger);
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module/upsert";
			$result = $this->post_to_zoho($zoho_url, $post);
			return $result;
		}

		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}

	

	function update_to_zoho($zoho_url, $fields){
		$authtoken = $this->authtoken;

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $zoho_url); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
		$headers = array(); 
		$headers[] = "Authorization: ".$authtoken; 
		$headers[] = "Content-Type: application/json";  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		$response = curl_exec($ch); 
		$err = curl_errno($ch);
		
		curl_close ($ch);
		if ($err) {
		  return $err;
		} else {
		  return $response;
		}

	}

	public function deleteRecords($id , $module)
	{
		try
		{
			$post = array();
			$post['ids'] = $id;
			$url = "https://www.zohoapis.com/crm/v2/$module";

			$fields_string = http_build_query($post, '', "&");
			$zoho_url = $url . "?$fields_string";

			$result = $this->delete_from_zoho($zoho_url);
			return $result;
			
		}catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}
	}

	

	private function delete_from_zoho($url){
		
		$authtoken = $this->authtoken;
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

		$headers = array();
		$headers[] = "Authorization: ".$authtoken;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch); 
		$err = curl_errno($ch);
		
		curl_close ($ch);
		if ($err) {
		  return $err;
		} else {
		  return $response;
		}


	}

	public function uploadFile($module,$content, $id)
	{
		try
		{
			$post['file'] = new \CURLFile($content);
			$ffilesize = filesize($content);
			if ($ffilesize >  20000000)
			{
				die("File size must be less than 20MB");
			}			
			$zoho_url = "https://www.zohoapis.com/crm/v2/$module/$id/Attachments";
			$result = $this->upload_to_zoho($zoho_url, $post);
			return $result;
		}

		catch(Exception $e)
		{
			$this->error = $e->getmessage();
		}

	}

	function upload_to_zoho($zoho_url, $fields){
		
		$authtoken = $this->authtoken;

		$ch=curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_URL,$zoho_url);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		$headers = array(); 
		$headers[] = "Authorization: ".$authtoken; 
		$headers[] = "Content-Type: multipart/form-data"; 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 

		$response = curl_exec($ch); 
		$err = curl_errno($ch);
		
		curl_close ($ch);
		if ($err) {
		  return $err;
		} else {
		  return $response;
		}
	}


	
}
