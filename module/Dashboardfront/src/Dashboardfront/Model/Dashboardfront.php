<?php
/*
 *@author : Ashwani Singh 
 *@date : 30-09-2013 
 *-----------------------------------------
 *        modified
 *-----------------------------------------
 *
 */

namespace Dashboardfront\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Dashboardfront implements InputFilterAwareInterface
{
	public $id;
	public $name;
	public $email;
        public $password ;
    protected $inputFilter;
	
	public function exchangeArray($data)
	{  
        print_r($data) ;
        die ;
        $this->rid     = (!empty($data['rid'])) ? $data['rid'] : null;
        $this->role_name     = (!empty($data['role_name'])) ? $data['role_name'] : null;
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		// $this->uname = (!empty($data['uname'])) ? $data['uname'] : null;
		$this->email  = (!empty($data['email'])) ? $data['email'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->status  = (!empty($data['status'])) ? $data['status'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
