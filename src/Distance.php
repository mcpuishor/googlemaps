<?php

namespace mcpuishor\googlemaps;

use mcpuishor\googlemaps\GooglemapsConstants;

class Distance extends DistanceMatrix {

	public function distance($origin, $destination, $units = GooglemapsConstants::UNITS_METRIC)
	{
		$self = $this->setUnits($units);
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