<?php

class KonsumenTest extends WebTestCase
{
	public $fixtures=array(
		'konsumens'=>'Konsumen',
	);

	public function testShow()
	{
		$this->open('?r=konsumen/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=konsumen/create');
	}

	public function testUpdate()
	{
		$this->open('?r=konsumen/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=konsumen/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=konsumen/index');
	}

	public function testAdmin()
	{
		$this->open('?r=konsumen/admin');
	}
}
