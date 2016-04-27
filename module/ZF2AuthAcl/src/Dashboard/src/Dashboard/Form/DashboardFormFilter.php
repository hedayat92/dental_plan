<?php
/**
 *@author : Ashwani Singh
 *@date : 01-10-2013
 *@desc : Album Form class
 */

namespace Ragister\Form;

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;


class RagisterFormFilter extends InputFilter
{
	public function __construct()
	{
        $this->add(array(
			'name' => 'id',
			'required' => true,
			'filters' => array(
				array('name' => 'Int'),
			),
		));

        $this->add(array(
			'name' => 'uname',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' =>100,
					),
				),
			),
		));

		$this->add(array(
			'name' => 'email',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' =>100,
					),
				),
			),
		));
		$this->add(array(
			'name' => 'password',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
			),
		));
        $this->add(array(
			'name' => 'conf_passwrd',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' =>100,
					),
				),
			),
		));
         $this->add(array(
			'name' => 'captchaimg_signup',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' =>100,
					),
				),
			),
		));



    }
}
