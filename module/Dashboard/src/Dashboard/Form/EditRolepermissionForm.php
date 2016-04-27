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
class EditRolePermissionForm extends Form 
{   
	public function __construct($roledetail=null)
	{   
     // $this->url = $role;
	   parent::__construct('editrolepermissionform');
	    $this->add(array(
			'name' => 'rid',
			'type' => 'Hidden',
		    'attributes' => array(
		    		
		    		'value'  =>$roledetail[0]['rid'],
		    		'id'  =>'rid' ,
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
		    		'value'  => $roledetail[0]['role_name'],
		    		'placeholder'  => 'Please Enter Role Here',
		    	),		
		));
       $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'editrolepermission',
                'class' =>   'btn btn-default submit',
                'height' => '30px;' ,
            )
        ));
	}    
}
