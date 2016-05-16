<?php

class PartnerTest extends WebTestCase
{
	public $fixtures=array(
		'partners'=>'Partner',
	);

	public function testShow()
	{
		$this->open('?r=partner/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=partner/create');
	}

	public function testUpdate()
	{
		$this->open('?r=partner/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=partner/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=partner/index');
	}

	public function testAdmin()
	{
		$this->open('?r=partner/admin');
	}
}
