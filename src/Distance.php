<?php

namespace mcpuishor\googlemaps;

class Distance extends DistanceMatrix {

	public function distance($origin, $destination, $units = "metric")
	{
		$self = ($units == "metric") ? $this->setMetricUnits() : $this->setImperialUnits();
		return $self->addOrigin($origin)
			->addDestination($destination)
			->execute();
	}

	public function formatResponse()
	{
		return [
			"origin" => $this->rawResponse->origin_addresses[0],
			"destination" => $this->rawResponse->destination_addresses[0],
			"distance" => $this->rawResponse->rows[0]->elements[0]->distance,
			"duration" => $this->rawResponse->rows[0]->elements[0]->duration,
		];
	}
}