<?php
namespace Configurator\Components;

class Step {
	public $title;
	public $content = "";
	protected $fields = [];

	public function __construct(array $init){
		if(array_key_exists('title',$init)){
			$this->title = $init['title'];
		}

		if(array_key_exists('content',$init)){
			$this->content = $init['content'];
		}

		foreach ($init['fields'] as $field) {
			$this->fields [] = new Field($field);
		}
	}

	public function isCompleted(){
		foreach ($this->fields as $field) {
			if(!$field->isFilled()){
				return false;
			}
		}

		return true;
	}


	public function fill(array $input = []){
		foreach ($this->fields as $field) {
			$field->fill($input);
		}
	}

	public function fields(){
		$fields = [];

		foreach ($this->fields as $field) {
			if(!$field->isHidden()){
				$fields [] = $field;
			}
		}

		return $fields;
	}
}
