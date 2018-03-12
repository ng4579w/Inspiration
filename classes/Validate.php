<?php
class Validate{
    private $_passed = false,
            $_errors = array(),
            $_db = null;
    public function __construct(){
        $this->_db = DB::getInstance();
    }
    public function check ($source, $items = array()){
        foreach($items as $item => $rules){ 
//                        $itemName=$rules['name'];
                foreach($rules as $rule => $rule_value){
//        echo "{$item} {$rule} must be {$rule_value}<br>";
                    $value = $source[$item];
                    $item = escape($item);
                   if($rule === 'name'){
                       $name =$rule_value;
                   }
                if($rule === 'required' && empty($value)) {
                        $this -> addError("{$name} is required");
                } else if(!empty($value)){
                    switch($rule){
                        case 'min':
                            if(strlen($value)<$rule_value){
                                $this -> addError("{$name} must be a minimum of {$rule_value} characters");
                            }
                        break;
                        case 'max':
                            if(strlen($value)>$rule_value){
                            $this -> addError("{$name} must be a maximum of {$rule_value} characters");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]){
                            $this -> addError("{$name} must match Password");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check ->count()){
                            $this ->addError("{$name} already exists.");
                            }
                        break;
                        case 'age':
                            if(strtotime($value) > $rule_value){
                            $this->addError("You must be 18 or older!");
                            }
                        break;
                        }
                    }
                }

            }
            if(empty($this->_errors)){
                    $this->_passed = true;
            }
        return $this;
    }
    private function addError($error){
            $this->_errors[] = $error;
    }
    public function errors(){
            return $this ->_errors;
    }
    public function passed(){
            return $this->_passed;
    }
}