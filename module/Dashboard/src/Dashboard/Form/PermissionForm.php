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
class PermissionForm extends Form 
{   
	public function __construct($resourcename = null)
	{   
	   parent::__construct('permissionform');
	    $this->add(array(
			'name' => 'id',
			'type' => 'Hidden',	
		));
         $this->add(array(
				'type' => 'Select',
				'name' => 'role_id',
				'options' => array(
						'label' => 'Select Role',
						'label_attributes' => array(
								'class'  => 'categoryLabel'
						),
						'value_options' => $this->getOptionsForSelect($resourcename),
				),
				'attributes' => array(
						'id'=>'role_id',
						'class'=>'form-control',
				
				)
	   )); 
        $this->add(array(
			'name' => 'permission',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'permission', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    	),		
		 ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submitpermission',
                'class' =>   'btn btn-primary',
            )
        )); 
	}
    public function getOptionsForSelect($resourcename)
	{  
        $selectData = array();
		$selectData[0]='Select Module Name';
        foreach ($resourcename as $selectOption => $value) {
	     	$selectData[$value['rid']] = $value['role_name'];
		}
      return $selectData;
	}  
}
