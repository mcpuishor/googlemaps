<?php

namespace mcpuishor\googlemaps;

class DistanceMatrix extends GoogleAPI {


	public function setEndPoint()
	{
		$this->endpoint = "distancematrix";
	}

	public function formatResponse()
	{
		$response = [];
		foreach($this->getRawParameters()["origins"] as $ko => $origin) {
			foreach($this->getRawParameters()["destinations"] as $do => $destination) {

					$response[] = [
						"origin" => $origin,
						"destination" => $destination,
						"distance" => $this->rawResponse->rows[$ko]->elements[$do]->distance,
						"duration" => $this->rawResponse->rows[$ko]->elements[$do]->duration,
					];
			}
		}
		return $response;
	}

	public function setImperialUnits() 
	{
		$this->setParameters(["units" => "imperial"]);
		return $this;
	}

	public function setMetricUnits()
	{
		$this->setParameters(["units" => "metric"]);
		return $this;
	}

	public function addOrigin(string $address)
	{
		$this->pushParameters("origins", $address);
		return $this;
	}

	public function addDestination(string $address)
	{
		$this->pushParameters("destinations", $address);
		return $this;
	}

	public function getRawParameters() 
	{
		return parent::getParameters();
	}

	protected function getParameters()
	{
		return array_merge(
			$this->parameters,
			[
				"origins" => implode("|", $this->parameters["origins"]),
				"destinations" => implode("|", $this->parameters["destinations"]),
			],
		);
	}
}

