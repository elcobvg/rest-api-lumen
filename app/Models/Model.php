<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * Magic method to restore OPcache objects from cache
     *
     * @param  array $array
     */
    public static function __set_state(array $array)
    {
        $class = get_called_class();
        $object = new $class;
        foreach ($object->fillable as $attribute) {
            $object->{$attribute} = $array['attributes'][$attribute];
        }
        $object->_id = $array['attributes']['_id'];
        return $object;
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \App\Extensions\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new \App\Extensions\Builder($query);
    }
}
