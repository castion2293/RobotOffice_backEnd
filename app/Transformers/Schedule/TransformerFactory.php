<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/25
 * Time: 上午 08:50
 */

namespace App\Transformers\Schedule;


use Illuminate\Support\Facades\App;

class TransformerFactory
{
    public static function create($type)
    {
        App::bind(AbstractTransformerType::class, 'App\\Transformers\\Schedule\\Transformer' . $type);
        return App::make(AbstractTransformerType::class);
    }
}