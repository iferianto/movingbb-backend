<?php

class AgenTest extends WebTestCase
{
	public $fixtures=array(
		'agens'=>'Agen',
	);

	public function testShow()
	{
		$this->open('?r=agen/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=agen/create');
	}

	public function testUpdate()
	{
		$this->open('?r=agen/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=agen/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=agen/index');
	}

	public function testAdmin()
	{
		$this->open('?r=agen/admin');
	}
}
