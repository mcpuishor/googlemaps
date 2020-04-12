<?php

namespace mcpuishor\googlemaps;

class Directions extends GoogleAPI {

	
	public function setEndpoint()
	{
		$this->endpoint = "directions";
	}


	public function addOrigin(string $address)
	{
		$this->setParameters(["origin" => $address]);
		return $this;
	}

	public function addDestination(string $address)
	{
		$this->setParameters(["destination" => $address]);
		return $this;
	}

	public function addWaypoint(string $address, bool $stopover= true)
	{
		$address = (!$stopover ? "via:" : "") . $address; 
		$this->pushParameters("waypoints", $address);
		return $this;
	}

	public function setOptimize(bool $optimize)
	{
		$this->setParameters("optimize", $optimize);
		return $this;
	}

	public function setTravelMode(string $mode = GooglemapsConstants::TRAVEL_DRIVING)
	{
		$this->setParameters("mode", $mode);
		return $this; 
	}

	public function setDepartureTime(string $departure_time)
	{
		$this->setParameters("departure_time", $departure_time);
		return $this; 
	}

	public function setArrivalTime(string $arrival_time)
	{
		$this->setParameters("arrival_time", $arrival_time);
		return $this; 
	}

	public function setRestiction(string $restriction)
	{
		$this->setParameters("avoid", $restriction);
		return $this;
	}

	public function getManifest()
	{
		return [
			"origin" => parent::getParameters()["origin"],
			"destination" => parent::getParameters()["destination"],
			"waypoints" => parent::getParameters()["waypoints"],
				
		];
	}

	public function getParameters()
	{
		return [
			"origin" => parent::getParameters()["origin"],
			"destination" => parent::getParameters()["destination"],
			"waypoints" => $this->pipeGlue(parent::getParameters()["waypoints"]),
			"avoid" => $this->pipeGlue(parent::getParameters()["avoid"]),
		]
	}

	protected function pipeGlue(array $values)
	{
		return implode("|", $values);
	}

	public function formatResponse()
	{
		//return "directions";
	}

}