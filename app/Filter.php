<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    /**
     * The attributes that should be casted to native types => handle the native mysql JSON type on the fly.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];


    public function places()
    {
        $options = json_decode(json_encode($this->options), false);

        $query = Place::query();
        $op    = $options->filter_operator === 'or' ? 'or' : 'and';
        $where = $op === 'and' ? 'where' : 'orWhere';

        foreach($options->filters as $filter) {
            switch ($filter->type) {

                case 'tag':
                    $value    = array_map('trim', explode(',', $filter->fields->value));
                    $operator = $filter->fields->operator;

                    if($operator == 'has_any') {
                        $query->withAnyTags($value);
                    } else {
                        $query->withAllTags($value);
                    }
                break;

                case 'priority':
                    $whereFnc = $where;
                    $column   = 'priority';
                    $value    = $filter->fields->value;
                    $operator = $this->word2op($filter->fields->operator);

                    $query->$whereFnc($column, $operator, $value);
                break;

                case 'unesco':
                    $column   = 'unesco_world_heritage';
                    $whereFnc = $where . (($filter->fields->operator === 'is') ? 'NotNull' : 'Null');

                    $query->$whereFnc($column);
                break;

                case 'wkt':
                    $whereFnc = $where . 'Raw';
                    $value    = $filter->fields->value;

                    // => VERY BAD!!!!!!!!!
                    if ($filter->fields->operator === 'is') {
                        $expression = "ST_WITHIN(location, ST_GeomFromText(?))";
                    } else {
                        $expression = "NOT ST_WITHIN(location, ST_GeomFromText(?))";
                    }
                    // <= VERY BAD!!!!!!!!!

                    $query->$whereFnc($expression, [$value]);
                break;

                // this filter would allow any user to select places from other users
                // => bad idea ;)
                /*ase 'place_id':
                    $operator = $filter->fields->operator === 'is' ? '' : 'Not';
                    $whereFnc = $where . $operator . 'In';
                    $column   = 'priority';
                    $value    = explode(',', $filter->fields->value);

                    $query->$whereFnc($column, $value);
                break;*/

                case 'visited':
                    $column   = 'visited_at';
                    $whereFnc = $where . (($filter->fields->operator === 'is') ? 'NotNull' : 'Null');

                    $query->$whereFnc($column);
                break;

                case 'creation_date':
                case 'visited_date':
                    $whereFnc = $where . 'Date';
                    $column   = $filter->type === 'visited_date' ? 'visited_at' : 'created_at';
                    $value    = Carbon::parse($filter->fields->value);
                    $operator = $this->word2op($filter->fields->operator);

                    $query->$whereFnc($column, $operator, $value);
                break;
            }

        }


        return $query->get();
    }

    private function word2op($op)
    {
        if ($op == 'less') {
            return '<';
        }

        if ($op == 'greater') {
            return '>';
        }

        // 'is'
        return '=';
    }
}
