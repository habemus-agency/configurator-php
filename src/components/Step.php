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

	private function getFieldByName(string $name){
		foreach ($this->fields as $field) {
			if($field->name == $name){
				return $field;
			}
		}

		return null;
	}


	public function fill(array $input = []){
		foreach ($input as $key => $value) {
			$field = $this->getFieldByName($key);

			if(!is_null($field)){
				$field->setValue($value);
			}
		}
	}

	public function fields(){
		return $this->fields;
	}
}
