<?php
namespace Dashboard\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
error_reporting(E_ALL & ~E_NOTICE) ;
class CategoryForm extends Form 
{   
	public function __construct($name = null,$users = null,$assignuserrole= null)
	{
		//print_r($resourcename);
		//print_r($name);

		parent::__construct('category');
        $this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			 'attributes' => array(
                'value' => $name['0']['id'],
            )	
		));
		  $this->add(array(
			'name' => 'catname',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'catname', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $name['0']['category_name'] ,
		    		'placeholder' =>'Please Enter Category Name ' ,
		    	),		
		));
         $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submitcategory',
                'class' =>   'btn btn-default submit',
            )
        ));
         $this->add(array(
            'name' => 'submiteditcategory',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submitedituser',
                'class' =>   'btn btn-default submit',
            )
        ));
        $this->add(array(
            'name' => 'cancel',
            'type' => 'Button',
            'attributes' => array(
                'value' => 'Cancel',
                'id'    => 'cancelsubmit',
                'class' =>   'btn btn-primary',
            )
        ));
    }  
}
