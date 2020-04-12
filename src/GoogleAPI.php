<?php

namespace mcpuishor\googlemaps;

use GuzzleHttp\Client as HttpClient;
use mcpuishor\googlemaps\GooglemapsConstants;

abstract class GoogleAPI {

	const  API_HOST 		= 'https://maps.googleapis.com/maps/api';
	const  RESPONSE_FORMAT 	= GooglemapsConstants::JSON; 

	protected $endpoint;

	private $apiKey;

	/**
	 * GuzzleHttp\Client
	 *
	 * @var GuzzleHttp\Client
	 */
	protected $httpClient;

	/**
	 * Response language. 
	 *
	 * @var string
	 */
	private $language;

	/**
	*
	* Parameters array to be passed on to the client
	*
	* @var array
	*/
	protected $parameters;

	/**
	*
	* The raw response received from Google
	*
	* @var array
	*/
	protected $rawResponse; 


	public function __construct(HttpClient $client)
	{
		$this->httpClient = $client;
		$this->parameters = [];
		$this->setEndpoint();
	} 

	public function setKey(string $key)
	{
		$this->apiKey = $key;

		return $this;
	}

	public function getKey()
	{
		return $this->apiKey;
	}

	public function setLanguage(string $language)
	{
		$this->language = $language;

		return $this;
	}

	public function setParameters(array $parameters) 
	{
		$this->parameters = array_merge( $this->parameters, $parameters);

		return $this; 
	}

	public function pushParameters(string $parameter, $value) 
	{
		$this->parameters[$parameter] = $this->parameters[$parameter] ?? array();
		array_push($this->parameters[$parameter], $value);

		return $this; 
	}

	protected function getParameters() 
	{
		return $this->getRawParameters();
	}

	final public function getRawParameters() 
	{
		return $this->parameters;
	}

	public function requestPayload()
	{
		return ['query' => array_merge([
							'key' => $this->apiKey,
							'language' => $this->language,
							], $this->getParameters())];
	}

	protected function getEndpoint()
	{
		return implode("/",  [	static::API_HOST, 
								$this->endpoint,
								static::RESPONSE_FORMAT
							]);
	}

	private function call()
	{
		$response = $this->httpClient->request('GET', 
											$this->getEndpoint(),
											$this->requestPayload()
										);
		if ($response->getStatusCode() !== 200) {
			// error to be customized
            throw Exception();
        }
        $this->rawResponse = json_decode($response->getBody()); 
	}

	public function setUnits(string $units)
	{
		$this->setParameters(["units" => $units]);
		return $this; 
	}	

	public function execute()
	{
		$this->call();
        if ($this->callResultIsOK()) {
        	return $this->formatResponse();
        }
	}

	public  function callResultIsOK() {
		return ($this->rawResponse->status === "OK");
	}

	abstract function setEndpoint();

	abstract function formatResponse();

}