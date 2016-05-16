<?php

class HargaTest extends WebTestCase
{
	public $fixtures=array(
		'hargas'=>'Harga',
	);

	public function testShow()
	{
		$this->open('?r=harga/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=harga/create');
	}

	public function testUpdate()
	{
		$this->open('?r=harga/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=harga/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=harga/index');
	}

	public function testAdmin()
	{
		$this->open('?r=harga/admin');
	}
}
