<?php
namespace Dashboard\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
error_reporting(E_ALL & ~E_NOTICE) ;
class UsersForm extends Form 
{   
	public function __construct($name = null,$users = null,$assignuserrole= null)
	{
		//print_r($resourcename);
	//	print_r($name);
		$conf_passwrd = $name['0']['password'];
		parent::__construct('ragister');
		$this->url = $name;
        $this->add(array(
			'name' => 'id',
			'type' => 'Hidden',	
		));
        $this->add(array(
			'name' => 'uname',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'name', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $users['0']['email'] ,
		    		'placeholder' =>'Enter Name ' ,
		    	),		
		));
		  $this->add(array(
			'name' => 'fname',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'fname', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $users['0']['fname'] ,
		    		'placeholder' =>'Enter First Name ' ,
		    	),		
		));
		 $this->add(array(
			'name' => 'lname',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'lname', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $users['0']['lname'] ,
		    		'placeholder' =>'Enter Last Name ' ,
		    	),		
		));
        $this->add(array(
			'name' => 'email',
			'type' => 'email',
			'id'=>'t1',
			'options' => array(
			    'label' => 'E-mail' ,
			    'margin-right'=>'30px;' ,
		    ),
		     'attributes' => array(
		    		'id' => 'email', 
                    'class'=>'input-sm',
		    		'required' => 'true',
		    		'value'  => $users['0']['email'],
		    		'placeholder' =>'Enter Your E-mail Id ' ,
		    	),			
		));
       $this->add(array(
			'name' => 'password',
			'type' => 'password',
			'id'=>'t1',
            'options' => array(
			    'label' => 'Password',
		    ),
		    'attributes' =>array('id' =>'password' , 
                     'class'=>'input-sm',
            'required' => 'true',
            'value'  => $name['0']['password'],

		    	),
		));
		  $this->add(array(
			'name' => 'conf_passwrd',
			'type' => 'password',
			'id'=>'t1',
			'options' => array(
			    'label' => 'Confirm Password',
		    ),
		    'attributes' =>array('id' =>'conf_passwrd' , 'class'=>'input-sm',
                    'required' => 'true',
                    'value'  => $conf_passwrd,
		    	),		
		));
        $this->add(array(
				'type' => 'Select',
				'name' => 'role_id',
				'options' => array(
						'label' => 'Select Role',
						'label_attributes' => array(
								'class'  => 'categoryLabel'
						),
						'value_options' => $this->getOptionsForSelect($name),
				),
				'attributes' => array(
						'id'=>'role_id',
						'class'=>'form-control',
						'value' => $assignuserrole ,
				)
	   )); 
         $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'buttonsubmit',
                'class' =>   'btn btn-default submit',
            )
        ));
         $this->add(array(
            'name' => 'submitedituser',
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
   public function getOptionsForSelect($name)
	{  
        $selectData = array();
		$selectData[0]='Select Role Name';
        foreach ($name as $selectOption => $value) {
	     	$selectData[$value['rid']] = $value['role_name'];
		}
      return $selectData;
	} 
}
