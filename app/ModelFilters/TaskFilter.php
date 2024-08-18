<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class TaskFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * @param $column
     * @return TaskFilter
     */
    public function orderByDesc($column)
    {
        return parent::orderByDesc($column);
    }

    /**
     * @param $name
     * @return TaskFilter|void
     */
    public function name($name)
    {
        if (is_string($name) && strlen($name) > 0) {
            return $this->where('name', 'ILIKE', "%{$name}%");
        }
    }

    /**
     * @param $id
     * @return TaskFilter
     */
    public function user($id)
    {
        return $this->where('user_id', $id);
    }

    /**
     * @param $status
     * @return TaskFilter
     */
    public function status($status)
    {
        return $this->where('status', $status);
    }
}
