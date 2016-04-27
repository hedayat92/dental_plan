<?php
namespace Dashboard\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
error_reporting(E_ALL & ~E_NOTICE) ;
class ClientsForm extends Form 
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
			'name' => 'clientname',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'clientname', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $name['0']['client_name'] ,
		    		'placeholder' =>'Please Enter Client Name ' ,
		    	),		
		));
         $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submitclients',
                'class' =>   'btn btn-default submit',
            )
        ));
         $this->add(array(
            'name' => 'submiteditclients',
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
