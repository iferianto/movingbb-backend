<?php

class KecamatanTest extends WebTestCase
{
	public $fixtures=array(
		'kecamatans'=>'Kecamatan',
	);

	public function testShow()
	{
		$this->open('?r=kecamatan/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=kecamatan/create');
	}

	public function testUpdate()
	{
		$this->open('?r=kecamatan/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=kecamatan/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=kecamatan/index');
	}

	public function testAdmin()
	{
		$this->open('?r=kecamatan/admin');
	}
}
