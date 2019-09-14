<?php

namespace mcpuishor\googlemaps;

class ReverseGeocode extends GoogleAPI {

	public function setEndpoint()
	{
		$this->endpoint = "geocode";
	}

	public function formatResponse()
	{
		return [
			"request" => [
				"latlng" => $this->parameters["latlng"],
			],
			"response" => [
	            'lat' => $this->rawResponse->results[0]->geometry->location->lat,
	            'lng' => $this->rawResponse->results[0]->geometry->location->lng,
	            'accuracy' => $this->rawResponse->results[0]->geometry->location_type,
	            'formatted_address' => $this->rawResponse->results[0]->formatted_address,
	            'viewport' => $this->rawResponse->results[0]->geometry->viewport,
	            'address_components' => $this->rawResponse->results[0]->address_components,
	            'place_id' => $this->rawResponse->results[0]->place_id,
            ]
		];	
	}

	public function location(array $latlng) 
	{
		$this->setParameters(["latlng" => implode(",", $latlng)]);
		return $this;
	}

}