<?php
/**
 *@author : Ashwani Singh
 *@date : 01-10-2013
 *@desc : Ragister Form class
 */

namespace Dashboard\Form;

use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;


class DashboardForm extends Form 
{   
	public function __construct($resourcename = null, $roleid= null, $permission_name =null)
	{   

		// print_r($resourcename) ;
	   
     parent::__construct('modulepermission');
	    $this->add(array(
			'name' => 'id',
			'type' => 'Hidden',	
		));
               $this->add(array(
			'name' => 'permission_name',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Permission Name',
             ),
            'attributes' => array(
		    		'id' => 'permission_name', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value'  => $permission_name,
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
		    	),			
		));
        $this->add(array(
				'type' => 'Select',
				'name' => 'module_id',
				'options' => array(
						//'label' => 'Category',
						'label_attributes' => array(
								'class'  => 'categoryLabel'
						),
						'value_options' => $this->getOptionsForSelect($resourcename),
				),
				'attributes' => array(
						'id'=>'module_id',
						'class'=>'form-control' ,
						'value'	=> $roleid	,	
				)
	   )); 
	   
	   $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'buttonsubmit',
                'class' =>   'btn btn-primary',
            )
        ));
  
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'buttonsubmitedit',
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
