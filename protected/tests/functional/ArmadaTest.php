<?php

class ArmadaTest extends WebTestCase
{
	public $fixtures=array(
		'armadas'=>'Armada',
	);

	public function testShow()
	{
		$this->open('?r=armada/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=armada/create');
	}

	public function testUpdate()
	{
		$this->open('?r=armada/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=armada/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=armada/index');
	}

	public function testAdmin()
	{
		$this->open('?r=armada/admin');
	}
}
