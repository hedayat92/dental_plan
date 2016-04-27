<?php
namespace Dashboard\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
error_reporting(E_ALL & ~E_NOTICE) ;
class ReportsForm extends Form 
{   
	public function __construct($reports = null,$category=null)
	{
	//print_r($reports);
	//	print_r($category);

		parent::__construct('ragister');
		$this->url = $name;
        $this->add(array(
			'name' => 'id',
			'type' => 'Hidden',	
		    'value' => $reports['0']['id'] ,
		));
        $this->add(array(
			'name' => 'report',
			'type' => 'Text',
			'options' => array(
			    'label' => 'Name',
             ),
            'attributes' => array(
		    		'id' => 'reportname', 
                                'class'=>'input-sm',
		    		'required' => 'true',
		    		'value' => $reports['0']['permission_name'] ,
		    		'placeholder' =>'Enter Report Name' ,
		    	),		
		));
       $this->add(array(
			'name' => 'reporturl',
			'type' => 'text',
			'id'=>'t1',
            'options' => array(
			    'label' => 'Report Url',
		    ),
		    'attributes' =>array('id' =>'reporturl' , 
                     'class'=>'input-sm',
            'required' => 'true',
            'value'  => $reports['0']['permission_url'],
            'placeholder' =>'Enter Report Url' ,
		    	),
		));
		  $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'reportsubmit',
                'class' =>   'btn btn-default submit',
            )
        ));
         $this->add(array(
            'name' => 'submiteditreports',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submiteditreports',
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
       $this->add(array(
                'type' => 'Select',
                'name' => 'cat_id',
                'options' => array(
                        'label' => 'Select Category Name',
                        'label_attributes' => array(
                                'class'  => 'categoryLabel'
                        ),
                        'value_options' => $this->getOptionsForSelect($category),
                ),
                'attributes' => array(
                        'id'=>'cat_id',
                        'required' => 'required',
                        'class'=>'form-controlcat',
                        'value' => $reports['0']['cat_id'] ,
                )
       )); 


    }  
   public function getOptionsForSelect($name)
	{  
        $selectData = array();
		$selectData[0]='Select Category Name';
        foreach ($name as $selectOption => $value) {
	     	$selectData[$value['id']] = $value['category_name'];
		}
      return $selectData;
	} 
}
