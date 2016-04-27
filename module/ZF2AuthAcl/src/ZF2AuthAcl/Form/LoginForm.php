<?php
namespace ZF2AuthAcl\Form;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;
class LoginForm extends Form
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
                'placeholder' => 'Please Enter Email Id',
                 'required'  => 'true'
            ),
            'options' => array(
                'label' => 'Email',
               
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => '**********',
                'required'  => 'true'
            ),
            'options' => array(
                'label' => 'Password', 

            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'loginCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
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
