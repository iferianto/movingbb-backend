<?php

class KaryawanTest extends WebTestCase
{
	public $fixtures=array(
		'karyawans'=>'Karyawan',
	);

	public function testShow()
	{
		$this->open('?r=karyawan/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=karyawan/create');
	}

	public function testUpdate()
	{
		$this->open('?r=karyawan/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=karyawan/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=karyawan/index');
	}

	public function testAdmin()
	{
		$this->open('?r=karyawan/admin');
	}
}
