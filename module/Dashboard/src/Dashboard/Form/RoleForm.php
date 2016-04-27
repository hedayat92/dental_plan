<?php
/**
 *@author : Ashwani Singh
 *@date : 01-10-2013
 *@desc : Ragister Form class
 */

namespace Dashboard\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
error_reporting(E_ALL & ~E_NOTICE);
class RoleForm extends Form 
{   
	public function __construct($role=null)
	{   
     // $this->url = $role;
	   parent::__construct('roleform'.$role['rid']);
	    $this->add(array(
			'name' => 'rid',
			'type' => 'Hidden',
		    'attributes' => array(
		    		
		    		'value'  => $role['rid'],
		    	),	
         ));
        $this->add(array(
			'name' => 'role',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Role',
             ),
            'attributes' => array(
		    		'id' => 'role', 
                    'class'=>'form-control',
		    		'required' => 'true',
		    		'value'  => $role['role_name'],
		    		'placeholder'  => 'Please Enter Role Here',
		    	),		
		));
       $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'buttonsubmitrole',
                'class' =>   'btn btn-default submit',
                'height' => '30px;' ,
            )
        ));
	}    
}
