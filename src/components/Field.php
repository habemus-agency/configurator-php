<?php
namespace Configurator\Components;

use Configurator\Traits\HasConditions;

class Field {
	use HasConditions;

	public $title;
	public $content;
	public $name;
	public $type = self::TYPE_RADIO;
	protected $choices = [];
	protected $value = null; //set with choice selection

	const TYPE_RADIO = 'radio';

	public function __construct(array $init){

		$choices = $init['choices'];
		unset($init['choices']);

		foreach ($init as $key => $value) {
			if(property_exists($this,$key)){
					$this->{$key} = $value;
			}
		}

		foreach($choices as $choice) {
			$this->choices [] = new Choice($choice);
		}
	}


	public function fill(array $input = []){
		//fill choices
		foreach ($this->choices as $choice) {
			$choice->setConditionsData($input);
		}

		//fill this
		$this->setConditionsData($input);

		foreach ($input as $key => $value) {
			if($this->name == $key){
				$this->setValue($value);
			}
		}
	}


	private function setValue($value){
		$is_valid = false;

		foreach ($this->choices as $choice) {
			if(!$choice->isHidden()){
				if($choice->value == $value){
					$is_valid = true;
				}
			}
		}

		if($is_valid == true and !$this->isHidden()){
			$this->value = $value;
		}
	}

	public function isFilled(){
		return !empty($this->value) or $this->isHidden();
	}

	public function choices(){
		$choices = [];

		foreach ($this->choices as $choice) {
			if(!$choice->isHidden()){
				$choices [] = $choice;
			}
		}

		return $choices;
	}

	public function value(){
		return $this->value;
	}

}
