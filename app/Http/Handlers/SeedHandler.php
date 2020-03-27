<?php

namespace App\Http\Handlers;

use \Bcn\Component\Json\Reader;

class SeedHandler implements \Iterator
{
	/**
	 *
	 *
	 */

	private $table = null;

	/**
	 *
	 *
	 */

	private $handle = null;

	/**
	 *
	 *
	 */

	private $reader = null;

	/**
	 *
	 *
	 */

	private $key = 0;

	/**
	 *
	 *
	 */

	private $dataset;

	/**
	 *
	 *
	 */

	public function __construct($table)
	{
		$this->table = $table;
	}

	/**
	 *
	 *
	 */

	public function rewind()
	{
		$this->handle = fopen(sprintf(database_path('seeds/%s/%s.json'), env('DB_SEED', 'data'), $this->table), "r");

		$this->reader = new Reader($this->handle);
		$this->reader->enter(Reader::TYPE_ARRAY);

		$this->key = 0;
	}

	/**
	 *
	 *
	 */

	public function current()
	{
		return $this->dataset->toArray();
	}

	/**
	 *
	 *
	 */

	public function key()
	{
		return $this->key;
	}

	/**
	 *
	 *
	 */

	public function next()
	{
		++$this->key;
	}

	/**
	 *
	 *
	 */

	public function valid()
	{
		$this->dataset = collect();
		$key = 0;

		while($row = $this->reader->read()) {
			$key++;

			$this->dataset->push((object)$row);

			if ($key >= 1000)
				break;
		}

		if ($this->dataset->count())
			return true;

		$this->reader->leave();
		fclose($this->handle);

		return false;
	}
}
