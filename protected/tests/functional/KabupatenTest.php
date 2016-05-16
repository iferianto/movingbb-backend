<?php

class KabupatenTest extends WebTestCase
{
	public $fixtures=array(
		'kabupatens'=>'Kabupaten',
	);

	public function testShow()
	{
		$this->open('?r=kabupaten/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=kabupaten/create');
	}

	public function testUpdate()
	{
		$this->open('?r=kabupaten/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=kabupaten/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=kabupaten/index');
	}

	public function testAdmin()
	{
		$this->open('?r=kabupaten/admin');
	}
}
