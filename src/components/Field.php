<?php
namespace Configurator\Components;

class Field {
	public $title;
	public $content;
	public $name;
	public $type; //radio
	protected $choices = [];
	protected $value = null; //set with choice selection

	const TYPE_RADIO = 'radio';
	//const TYPE_CHECKBOX = 'checkbox';

	public function __construct(array $init){

		foreach ($init['choices'] as $choice) {
			$this->choices [] = new Choice($choice);
		}

		unset($init['choices']);

		foreach ($init as $key => $value) {
			if(property_exists($this,$key)){
					$this->{$key} = $value;
			}
		}
	}

    public function setValue($value){
			$is_valid = false;

			foreach ($this->choices as $choice) {
				if($choice->value == $value){
					$is_valid = true;
				}
			}

			if($is_valid == true){
				$this->value = $value;
			}
    }

    public function isFilled(){
      return !empty($this->value);
    }

    public function choices(){
      return $this->choices;
    }

    public function value(){
      return $this->value;
    }
}
