<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SysOptions 
{
	public $cfg_id;
	public $cfg_site_url;
	public $cfg_site_name;
	protected $inputFilter;  
	
	public function exchangeArray($data)
	{
		$this->cfg_id = (!empty($data['id'])) ? $data['id'] : 0;
		$this->cfg_site_url = (!empty($data['site_url'])) ? $data['site_url'] : null;
		$this->cfg_site_name = (!empty($data['site_name'])) ? $data['site_name'] : null;
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
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'site_url',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'site_name',
                'required' => true,
                'filters'  => array(
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
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
   }
	
}
