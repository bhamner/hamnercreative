<?php

namespace App\Logic;
 
class FormInputBuilder
{

    private static $instance;

    private $input;

	private $name;

	private $value;
 

    public static function getInstance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setInput($input): self
    {
       	$this->input  = $input;
        return $this;
    }
 
    public function setName($name): self
    {
       	$this->name =  $name;
        return $this;
    }
 

    public function setValue($options): self
    {
       	$this->value = $options && $options->first() ? $options->first()->value : null;
        return $this;
    }
 
    public function build(): string
    {
    	if( !in_array( $this->input,['text','textarea','checkbox','number']) ) return null; 
    	//don't judge me, this is a valid case
 		$function ='build'.\ucfirst($this->input).'Input'; 
 		return $this->$function($this->name,$this->value);

    }

    private function buildTextInput($name,$value): string
    {
 	  return '<label for="'.$name.'_input" class="form-label">'.\str_replace('_', ' ', \ucwords($name)).'</label>
        <input type="text" class="form-control" id="content_'.$name.'" name="content_'.$name.'" placeholder="'.$name.'" 
        value="'.$value.'" />';
    }

    private function buildTextareaInput($name,$value): string
    {
  		return '<label for="'.$name.'_input" class="form-label">'.\str_replace('_', ' ', \ucwords($name)).'</label>
        	<textarea rows="3" class="form-control" id="content_'.$name.'" name="content_'.$name.'">'.$value.'</textarea>';
    }

    private function buildCheckboxInput($name,$value): string
    {
    	$value = $value ? 'checked':'';
    	return '<div class="form-check form-switch">
          <input value="1" name="content_'.$name.'" class="form-check-input" type="checkbox" role="switch" id="'.$name.'_input" '.$value . '><label class="form-check-label"  for="'.$name.'_input">'.\str_replace('_', ' ', \ucwords($name)).'</label>
        </div>';
    }

    private function buildNumberInput($name,$value): string
    {
 	  return '<label for="'.$name.'_input" class="form-label">'.\str_replace('_', ' ', \ucwords($name)).'</label>
        <input type="number" min="0" max="100000" class="form-control" id="content_'.$name.'" name="content_'.$name.'" placeholder="'.$name.'" 
        value="'.$value.'" />';
    }

}