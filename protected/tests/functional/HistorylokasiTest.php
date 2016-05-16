<?php

class HistorylokasiTest extends WebTestCase
{
	public $fixtures=array(
		'historylokasis'=>'Historylokasi',
	);

	public function testShow()
	{
		$this->open('?r=historylokasi/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=historylokasi/create');
	}

	public function testUpdate()
	{
		$this->open('?r=historylokasi/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=historylokasi/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=historylokasi/index');
	}

	public function testAdmin()
	{
		$this->open('?r=historylokasi/admin');
	}
}
