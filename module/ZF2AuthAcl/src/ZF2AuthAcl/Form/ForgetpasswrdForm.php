<?php
namespace ZF2AuthAcl\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class ForgetpasswrdForm extends Form
{

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Enter Registered Email',
                 'required'=>true,
            ),
            'options' => array(
                'label' => 'Email',
            )
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'id'=>'t1',
                         
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' =>array('id' =>'password' , 
                     'class'=>'form-control',
                     'placeholder' => 'Enter New Password',
                     'required' => 'true',
                ),
        ));
          $this->add(array(
            'name' => 'conf_passwrd',
            'type' => 'password',
            'id'=>'t1',
            'options' => array(
                'label' => 'Conferm Password',
            ),
            'attributes' =>array('id' =>'conf_passwrd' , 
                 'class'=>'form-control',
                 'required' => 'true',
                 'placeholder' => 'Retype New Password',
                ),      
        ));
         $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'class' => 'btn-login'
            )
        ));
    }
}
