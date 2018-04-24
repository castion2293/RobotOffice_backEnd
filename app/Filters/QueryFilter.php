<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/24
 * Time: 上午 08:31
 */

namespace App\Filters;


use Illuminate\Http\Request;

class QueryFilter
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->all();
    }
}