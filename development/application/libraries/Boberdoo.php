<?php
if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

define( 'BOBERDOO_API_ENDPOINT', 'https://mmtmarketing.leadportal.com/new_api/api.php?' );

define( 'BOBERDOO_METHOD_POST', 'post' );

define( 'BOBERDOO_METHOD_DELETE', 'delete' );

define( 'BOBERDOO_API_KEY', 'wkAzba8QwIbLbfwfGt9ibrma4auKMrwfwrwzMIba4QuJbL5J4t1SqUpp');

class Boberdoo{

	private function _send_request($params = array(), $http_method = 'get' ) {

		// Initializ and configure the request

		$params['Key'] = BOBERDOO_API_KEY;

		$params['Format'] = 'JSON';

		$queryString = http_build_query($params);

		$req = curl_init( BOBERDOO_API_ENDPOINT.$queryString);

		//curl_setopt( $req, CURLOPT_SSL_VERIFYPEER, $this->_conf['stripe_verify_ssl'] );

		// curl_setopt( $req, CURLOPT_HTTPAUTH, CURLAUTH_ANY );

		// curl_setopt( $req, CURLOPT_USERPWD, $key.':' );

		curl_setopt( $req, CURLOPT_RETURNTRANSFER, TRUE );

		// Are we using POST? Adjust the request properly

		if( $http_method == BOBERDOO_METHOD_POST ) {

			curl_setopt( $req, CURLOPT_POST, TRUE );

			curl_setopt( $req, CURLOPT_POSTFIELDS, http_build_query( $params, NULL, '&' ) );

		}

		

		if( $http_method == BOBERDOO_METHOD_DELETE ) {

			curl_setopt( $req, CURLOPT_CUSTOMREQUEST, "DELETE" );

			curl_setopt( $req, CURLOPT_POSTFIELDS, http_build_query( $params, NULL, '&' ) );

		}

		

		// Get the response, clean the request and return the data

		$response = curl_exec( $req );

		curl_close( $req );

		return $response;

	}



	public function getCampaign($partnerId = 0){

		$params['API_Action'] = 'getFilterSets';

		$params['Partner_ID'] = $partnerId;

		$data = $this->_send_request($params);

		$response = json_decode($data);



		if(isset($response->response->errors)){

			return array();

		}else{

			if(isset($response->response->filter_sets->set)){

				return $response->response->filter_sets->set;

			}else{

				return array();

			}

		}

	}



	/*

    * status 0 - Not Active, 1 - Active

	*/

	public function setCampaignStatus($partnerId = 0, $filterSetId = 0, $status = 0){

		$params['API_Action'] = 'setFilterSetStatus';

		$params['Partner_ID'] = $partnerId;

		$params['Filter_Set_ID'] = $filterSetId;

		$params['Status'] = $status;

		$data = $this->_send_request($params);

		$response = json_decode($data);

		if(isset($response->response->errors)){

			return array('error' => true, 'message' => $response->response->errors);

		}else{

			return array('error' => false, 'message' => $response->response);

		}

	}



	public function createPartner($params = array()){

		$params['API_Action'] = 'createNewPartner';

		$data  = $this->_send_request($params);

		$response = json_decode($data);

		if(isset($response->response->errors)){

			return array('error' => true, 'message' => $response->response->errors);

		}else{

			return array('error' => false, 'message' => $response->response);

		}		

	}



	public function submtPayment($params = array()) {
		$params['API_Action'] = 'submitPayment';
		$data = $this->_send_request($params);
		$response = json_decode($data);
		if(isset($response->response->errors)){

			return array('error' => true, 'message' => $response->response->errors);

		}else{

			return array('error' => false, 'message' => $response->response);

		}		

	}



	public function getPartnerInfo($partnerId = 0){

		$params['API_Action'] = 'getPartnerSettings';

		$params['Partner_ID'] = $partnerId;

		$data = $this->_send_request($params);

		$response = json_decode($data);

		return $response;			

	}

}