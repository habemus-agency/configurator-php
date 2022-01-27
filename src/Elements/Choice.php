<?php
namespace Configurator\Elements;

use Configurator\Traits\HasConditions;

class Choice {
	use HasConditions;

	public $label;
	public $value;
	public $image;

	public function __construct(array $init){
		foreach ($init as $key => $value) {
			if(property_exists($this,$key)){
				$this->{$key} = $value;
			}
		}
	}
}
