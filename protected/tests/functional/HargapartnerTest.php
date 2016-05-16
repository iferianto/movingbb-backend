<?php

class HargapartnerTest extends WebTestCase
{
	public $fixtures=array(
		'hargapartners'=>'Hargapartner',
	);

	public function testShow()
	{
		$this->open('?r=hargapartner/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=hargapartner/create');
	}

	public function testUpdate()
	{
		$this->open('?r=hargapartner/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=hargapartner/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=hargapartner/index');
	}

	public function testAdmin()
	{
		$this->open('?r=hargapartner/admin');
	}
}
