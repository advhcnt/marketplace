<?php
class Paypal{
	private $user='jnddndshihhjsq' ;
	private $pwd='jnsjqshjsqj';
	private $signature='mldslfhhjdjhqshgghelkjedgyehjhehgghsqhezhjhghhjezil';

	public $endpoint=" https://api.sandbox.paypal.com/v2";#"https://api-3T.sandbox.paypal.com/mvp"; 


	public $errors=array(); 

	public function __construct__($user=false,$pwd=false,$signature=false,$prod=false)
	{
		if ($user) {
			$user=$this->user;
		}

		if ($pwd) {
			$pwd=$this->pwd;
		}
		if ($signature) {
			$signature=$this->signature;
		}
		if ($prod) {
			$this->endpoint=str_replace('sandbox', " ", $this->endpoint);
		}

	}



	public function request($method,$params){
		$params=array_merge($params,array(
			'METHODE'=>$method,
			'VERSION'=>116,
			'USER'=>$this->user,
			'PWD'=>$this->pwd,
			'SIGNATURE'=>$this->signature

			));
		$params=http_build_query($params);

		$curl=curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL=>$this->endpoint,
			CURLOPT_POST=>1,
			CURLOPT_POSTFIELDS=>$params,
			CURLOPT_RETURNTRANSFER=>1,
			CURLOPT_SSL_VERIFYPEER=>0,
			CURLOPT_SSL_VERIFYHOST=>0,
			CURLOPT_VERBOSE=>1

		));

		$response=curl_exec($curl);

		parse_str($response,$responseArray);

		if (curl_errno($curl))
		{
			$this->errors=curl_error($curl);
			curl_close($curl);
			//var_dump($this->errors);
			//die();
			return false;


		}
		else{
			if ($responseArray['ACK']=="success")
			{
				curl_close($curl);
				return $responseArray;
			}
			else
			{
				var_dump($responseArray);
				$this->errors=curl_error($curl);
				curl_close($curl);
				//var_dump($this->errors);
				//die();
				return false;
			}
		}


	}

}

?>