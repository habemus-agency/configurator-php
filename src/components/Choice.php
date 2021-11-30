<?php
namespace Configurator\Components;

class Choice {
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
