<?php
/**
 * The Hover API Helper class for PHP
 * @author zgbjgg@gmail.com
 *
 */
class TheHover {
	
	// Client Keys 
	private $clientKey;

	// API Version
	private $apiVersion = "v1";
	
	// API URL
	private $apiUrl = "https://127.0.0.1:8080/";

	// API Agent
	private $agent = "TheHover-SDK-PHP-0.1";
	
	function __construct($clientKey, $apiUrl, $encoding) {
		$this->clientKey = $clientKey;
		$this->encoding = $encoding;
		$this->apiUrl = $apiUrl;
	}
	
	/**
	 * Does the curl call to the The Hover API.
	 * 
	 * @param string $resource
         * @param string $method
	 * @param array $data Array with data (if any)
	 * @return Ambigous <boolean, mixed> Returns the API json as an object, or returns false on failure
	 */
	private function doQuery($resource, $data = null, $method) {
		$url = $this->apiUrl . $this->apiVersion . '/' . $resource;

		// Store $headers
		$headers = array();

		$headers[0] = "Ckey: ".$this->clientKey;		

		// Build data if method is different of GET
		if ($method != 'GET') {
			                
			// initiate curl
                	$ch = curl_init($url);
			
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data));
                	$headers[1] = "Accept: application/json";
                	$headers[2] = "Content-Type: application/json";
		} else {
			$url .= '?' . http_build_query($data);
		
                	// initiate curl
                	$ch = curl_init($url);
		}

		// Agent 
		$headers[3] = 'User-Agent: ' . $this->agent;
	
		// Set cURL headers
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		
	
		// Set cURL options	
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_VERBOSE, true);
		
		// Execute then close curl connection
		$response = curl_exec($ch);
	
		if ( $this->encoding == 'json') {
			$json = json_decode($response); 
			if (json_last_error() === JSON_ERROR_NONE) { 
   				return $json;	
			} else {
 				$info = curl_getinfo($ch);
				return $info;
			}
		}
	}

	/**
	 * Create a user in the Hover system using Hover API, the next attributes
	 * in the User function must be required:
	 * 
         *  - branch_id: The parent branch id of the user to register
         *	- profile_id: The profile of the user to register
         *	- user_id: The parent user id of the user to register
         *	- coloruser: Must be "blue" or "black", a user blue can create users, user black is the end user
         *	- phase: The phase number which the user is registered, must be "phase1", "phase2", "phase3" or "phase4"
         * 
         * @param req_data representing the data to create
         */
        function usersCreate($req_data) {
        	return $this->doQuery("user", $req_data, 'POST');
        }

	/**
	* Get the user info on a specific phase using the Hover API, the next attributes
	* in the User function must be required:
	* 
	* 	- branch_id: The branch_id of the parent user 
	*	- user_id: The id of the registered user  
	*	- phase: It could be all, phase1, phase2, phase3 or phase4
	* 
	* @param req_data representing the object data to fetch
	*/
	function usersFetch($req_data) {
		return $this->doQuery("user", $req_data, 'GET');
	}

        /**
        *  Update a profile to the parent user in the Hover system using Hover API.
        *
        * @param req_data representing the data to update the profile
        * @param callback function to set the body response
        */
        function usersUpdate($req_data){
        	return $this->doQuery("user", $req_data, 'PUT');
        }

        /**
        * Find all users matching the incoming data set in the Hover system using Hover API, the next attributes
        * must be required, not null or empty.
        *
        *  - branch_id: The parent branch_id of the user
        *  - broot: The parent branch_id of the user
        *  - pagination: The number of elements per page to slide data
        *  - thql: Query to execute
        *  _ page: The number of page to fetch
        *
        * @param req_data representing the object data to find
        * @param callback function to set the body response
        */
        function search($req_data){
   		return $this->doQuery("user/search/ql", $req_data, 'GET');
         }
}
?>
