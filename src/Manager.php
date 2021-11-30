<?php
namespace Configurator;

use Components\Step;

class Manager {
	protected $steps;
	protected $current = 0;
	protected $completed = 0;

	public function __construct(array $init,array $input = [],array $filled = []) {
		$is_consequent = true;

		foreach ($init as $step) {
			$step = new Step($step);
			$step->fill($input + $filled);

			if($step->isCompleted() and $is_consequent){
				$this->completed++;
			}else{
				$is_consequent = false;
			}

			$this->steps [] = $step;
		}

		if(array_key_exists('step',$input)){
			$this->current = $input['step'];
		}

		if(array_key_exists('step',$_GET)){
			$this->current = $_GET['step'];
		}

		if($this->completed < $this->current){
			$this->current = $this->completed;
		}

	}


	public function getStepsNumber() {
		return count($this->steps);
	}

	public function isCompleted() {
		return $this->getStepsNumber() == $this->completed;
	}

	public function isFirstStep() {
		return $this->current == 0;
	}

	public function isLastStep() {
		return $this->current == ($this->getStepsNumber() - 1);
	}

	public function getCurrentStepNumber(){
		return $this->current;
	}

	public function current() {
		return $this->steps[$this->current];
	}

	public function filled(){
		$k_v = [];

		for ($i=0; $i < count($this->steps); $i++) {
			foreach ($this->steps[$i]->fields() as $f) {
				if($f->isFilled()){
					$k_v [$f->name] = $f->value();
				}
			}
		}

		return $k_v;
	}

	public function getPrevLink(string $base_url = '') {
		return $base_url . "?" . http_build_query([ 'step' => ($this->current - 1) ]);
	}

	public function getResetLink(string $base_url = '') {
		return $base_url . "?" . http_build_query([ 'reset' => true ]);
	}


}
