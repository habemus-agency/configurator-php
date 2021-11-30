# PHP Configurator

### Installation

```

$ composer require apdev/configurator-php

```

## Basic Usage with PHP sessions

```php
<?php
session_start(); //IMP

use Configurator\Manager;

if( is_null($_SESSION['filled_data']) ){
  $_SESSION['filled_data'] = [];
}

$input = $_POST; // or $_GET
$filled = $_SESSION['filled_data']; // or cookies

$config = [
	//step 1
	[
		'fields' => [
				//field 1
				[
					'name' => 'field_1_name',
					'type' => 'radio',
					'choices' => [
						//choice 1
						[
								'label' => 'Choice 1 Label',
								'value' => 'A',
						],
						//choice 2
						[
								'label' => 'Choice 2 Label',
								'value' => 'B',
						],
						...
					],
				],
				...
		],
	],
	...
];

//create instance
$configurator = new Manager($config,$input,$filled);

//update filled data
$_SESSION['filled_data'] = $configurator->filled();

if($configurator->isCompleted()){
  // do stuff with filled data
}

//base url should be always set to current url (without params)
$configurator->setBaseUrl("https://base.url/configurator-page");


$step = $configurator->current(); //get current step

//utility functions
$configurator->getStepsNumber(); //gets total steps
$configurator->getCurrentStepNumber();
$configurator->isFirstStep();
$configurator->isLastStep();
$configurator->getPrevLink();
$configurator->getResetLink();
$configurator->getFormAction();

```

## In Twig template

```html

	...

	<form method="POST" action="{{ configurator.getFormAction() }}">

		<input type="hidden" name="step" value="{{ configurator.getCurrentStepNumber() + 1 }}">

		{% for field in step.fields() %}
			<h2>{{ field.title }}</h2>
			<div>{{ field.content }}</div>

			{% for choice in field.choices() %}
				<div class="form-group">
					<input type="{{ choice.type }}" name="{{ field.name }}" value="{{ choice.value }}" {{ choice.value == field.value() ? 'checked' }}>
					<label>{{ choice.label }}</label>
				</div>
			{% endfor %}
		{% endfor %}

		{% if not configurator.isFirstStep() %}
			<a href="{{ configurator.getPrevLink() }}">Back</a>
		{% endif %}

		<input type="submit" value="Next">
	</form>

```
