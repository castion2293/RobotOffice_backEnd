<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/25
 * Time: 上午 08:51
 */

namespace App\Transformers\Schedule;


abstract class AbstractTransformerType
{
    abstract public function transform($attributes);
}