<?php

class AreaTest extends WebTestCase
{
	public $fixtures=array(
		'areas'=>'Area',
	);

	public function testShow()
	{
		$this->open('?r=area/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=area/create');
	}

	public function testUpdate()
	{
		$this->open('?r=area/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=area/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=area/index');
	}

	public function testAdmin()
	{
		$this->open('?r=area/admin');
	}
}
