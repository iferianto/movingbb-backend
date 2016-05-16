<?php

class PropinsiTest extends WebTestCase
{
	public $fixtures=array(
		'propinsis'=>'Propinsi',
	);

	public function testShow()
	{
		$this->open('?r=propinsi/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=propinsi/create');
	}

	public function testUpdate()
	{
		$this->open('?r=propinsi/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=propinsi/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=propinsi/index');
	}

	public function testAdmin()
	{
		$this->open('?r=propinsi/admin');
	}
}
