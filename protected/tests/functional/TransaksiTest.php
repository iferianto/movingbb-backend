<?php

class TransaksiTest extends WebTestCase
{
	public $fixtures=array(
		'transaksis'=>'Transaksi',
	);

	public function testShow()
	{
		$this->open('?r=transaksi/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=transaksi/create');
	}

	public function testUpdate()
	{
		$this->open('?r=transaksi/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=transaksi/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=transaksi/index');
	}

	public function testAdmin()
	{
		$this->open('?r=transaksi/admin');
	}
}
