<?php

class CabangTest extends WebTestCase
{
	public $fixtures=array(
		'cabangs'=>'Cabang',
	);

	public function testShow()
	{
		$this->open('?r=cabang/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=cabang/create');
	}

	public function testUpdate()
	{
		$this->open('?r=cabang/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=cabang/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=cabang/index');
	}

	public function testAdmin()
	{
		$this->open('?r=cabang/admin');
	}
}
