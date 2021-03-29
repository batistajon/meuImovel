<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{		
	/**
	 * model
	 *
	 * @var mixed
	 */
	protected $model;
		
	/**
	 * Method __construct
	 *
	 * @param Model $model [explicite description]
	 *
	 * @return void
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Method selectCoditions
	 *
	 * @param $coditions $coditions [explicite description]
	 *
	 * @return void
	 */
	public function selectConditions($conditions): void
	{
		$expressions = explode(';', $conditions);
		foreach($expressions as $e) {
			$exp = explode(':', $e);

			$this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
		}
	}
	
	/**
	 * Method selectFilter
	 *
	 * @param $filters $filters [explicite description]
	 *
	 * @return void
	 */
	public function selectFilter($filters): void
	{
		$this->model = $this->model->selectRaw($filters);
	}
			
	/**
	 * Method getResult
	 *
	 * @return object
	 */
	public function getResult(): object
	{
		return $this->model;
	}
}