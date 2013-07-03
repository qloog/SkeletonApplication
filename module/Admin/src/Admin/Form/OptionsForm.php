<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element; 

class OptionsForm extends Form
{
	public function __construct() 
	{
		parent::__construct('options');

		$this->setAttribute('method', 'post');
		/**
		 * 可参考：
		 * http://stackoverflow.com/questions/13615065/strange-form-validation-behavior-in-zend-framework-2
		 * http://framework.zend.com/manual/2.1/en/modules/zend.form.elements.html
		 */

		$hidden = new Element\Hidden('id');
		$hidden->setValue('3');

		$site_url = new Element\Text('site_url');
		$site_url->setLabel('站点URL');
		$site_url->setLabelAttributes(array(
			'for' => $site_url->getName(),
			'class' => 'control-label'
		));
		$site_url->setAttributes(array(
			'id' => $site_url->getName(),
			'placeholder' => '站点URL',
			'class' => ''
		));

		$site_name = new Element\Text('site_name');
		$site_name->setLabel('站点名称');
		$site_name->setLabelAttributes(array(
			'for' => $site_name->getName(),
			'class' => 'control-label'
		));
		$site_name->setAttributes(array(
			'id' => $site_name->getName(),
			'placeholder' => '站点名称',
			'class' => ''
		));

		$submit = new Element\Button('submit');
		$submit->setLabel('提交')->setValue('submit');
		$submit->setAttributes(array(
			'id' => $submit->getName(),
			'class' => 'btn btn-info icon-ok bigger-110',
			'type' => 'submit',
		));

		$this->add($hidden);
		$this->add($site_url);
		$this->add($site_name);
		$this->add($submit);

	}

}
