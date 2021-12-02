<?php
namespace Configurator\Traits;

trait hasConditions {

	protected $hide_if = [];
	private $conditions_data = [];

	public function setConditionsData(array $input){

		//create an array with fields required for validation from input
		$condition_fields = [];
		foreach ($this->hide_if as $condition) {
			$condition_fields [] = key($condition);
		}

		$condition_fields = array_unique($condition_fields); //remove duplicates

		//retrieve only needed input data
		foreach ($condition_fields as $cond_field) {
			if(array_key_exists($cond_field,$input)){
				$this->conditions_data[$cond_field] = $input[$cond_field];
			}
		}
	}

	/**
	 * multiple conditions are evaluated as OR statements, if at least one of the conditions is verified, the field is hidden
	 */
	public function isHidden(){
		$is_hidden = false;

		foreach ($this->hide_if as $condition) {
			$key = key($condition);
			$value = $condition[$key];

			if( array_key_exists($key,$this->conditions_data) ){
				if($this->conditions_data[$key] == $value){
					$is_hidden = true;
				}
			}
		}

		return $is_hidden;
	}
}
