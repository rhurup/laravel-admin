<?php

namespace Encore\Admin\Grid\Concerns;

use Encore\Admin\Grid\Column;
use Encore\Admin\Grid\Model;
use Encore\Admin\Grid\Tools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Trait HasQuickSearch.
 *
 * @property Collection $columns
 * @property Tools $tools
 *
 * @method Model model()
 */
trait HasQuickSearch
{
    /**
     * @var string
     */
    public static $searchKey = '__search__';

    /**
     * @var array|string|\Closure
     */
    protected $search;

    /**
     * @param array|string|\Closure
     *
     * @return Tools\QuickSearch
     */
    public function quickSearch($search = null)
    {
        if (func_num_args() > 1) {
            $this->search = func_get_args();
        } else {
            $this->search = $search;
        }

        return tap(new Tools\QuickSearch(), function ($search) {
            $this->tools->append($search);
        });
    }

    /**
     * Apply the search query to the query.
     *
     * @return mixed|void
     */
    protected function applyQuickSearch()
    {
        if (!$query = request()->get(static::$searchKey)) {
            return;
        }

        if ($this->search instanceof \Closure) {
            return call_user_func($this->search, $this->model(), $query);
        }

        if (is_string($this->search)) {
            $this->search = [$this->search];
        }

        if (is_array($this->search)) {
            $this->model()->where(function (Builder $builder) use ($query) {
                foreach ($this->search as $column) {
                    $this->addWhereLikeBinding($builder, $column, true, '%'.$query.'%');
                }
            });
        } elseif (is_null($this->search)) {
            $this->model()->where(function (Builder $builder) use ($query) {
                $this->addWhereBindings($builder, $query);
            });
        }
    }

    /**
     * Add where bindings.
     *
     * @param string $query
     */
    protected function addWhereBindings(Builder $builder, $query)
    {
        $queries = preg_split('/\s(?=([^"]*"[^"]*")*[^"]*$)/', trim($query));

        foreach ($this->parseQueryBindings($queries) as list($column, $condition, $or)) {
            if (0 !== preg_match('/(?<not>!?)\((?<values>.+)\)/', $condition, $match)) {
                $this->addWhereInBinding($builder, $column, $or, (bool) $match['not'], $match['values']);
                continue;
            }

            if (0 !== preg_match('/\[(?<start>.*?),(?<end>.*?)]/', $condition, $match)) {
                $this->addWhereBetweenBinding($builder, $column, $or, $match['start'], $match['end']);
                continue;
            }

            if (0 !== preg_match('/(?<function>date|time|day|month|year),(?<value>.*)/', $condition, $match)) {
                $this->addWhereDatetimeBinding($builder, $column, $or, $match['function'], $match['value']);
                continue;
            }

            if (0 !== preg_match('/(?<pattern>%[^%]+%)/', $condition, $match)) {
                $this->addWhereLikeBinding($builder, $column, $or, $match['pattern']);
                continue;
            }

            if (0 !== preg_match('/\/(?<value>.*)\//', $condition, $match)) {
                $this->addWhereBasicBinding($builder, $column, $or, 'REGEXP', $match['value']);
                continue;
            }

            if (0 !== preg_match('/(?<operator>>=?|<=?|!=|%){0,1}(?<value>.*)/', $condition, $match)) {
                $this->addWhereBasicBinding($builder, $column, $or, $match['operator'], $match['value']);
                continue;
            }
        }
    }

    /**
     * Parse quick query bindings.
     *
     * @return array
     */
    protected function parseQueryBindings(array $queries)
    {
        $columnMap = $this->columns->mapWithKeys(function (Column $column) {
            $label = $column->getLabel();
            $name = $column->getName();

            return [$label => $name, $name => $name];
        });

        return collect($queries)->map(function ($query) use ($columnMap) {
            $segments = explode(':', $query, 2);

            if (2 !== count($segments)) {
                return;
            }

            $or = false;

            list($column, $condition) = $segments;

            if (Str::startsWith($column, '|')) {
                $or = true;
                $column = substr($column, 1);
            }

            $column = $columnMap[$column];

            return [$column, $condition, $or];
        })->filter()->toArray();
    }

    /**
     * Add where like binding to model query.
     */
    protected function addWhereLikeBinding(Builder $builder, string $column, bool $or, string $pattern)
    {
        $connectionType = $builder->getModel()->getConnection()->getDriverName();
        $likeOperator = 'pgsql' === $connectionType ? 'ilike' : 'like';

        $method = $or ? 'orWhere' : 'where';

        $builder->{$method}($column, $likeOperator, $pattern);
    }

    /**
     * Add where date time function binding to model query.
     */
    protected function addWhereDatetimeBinding(Builder $builder, string $column, bool $or, string $function, string $value)
    {
        $method = ($or ? 'orWhere' : 'where').ucfirst($function);

        $builder->{$method}($column, $value);
    }

    /**
     * Add where in binding to the model query.
     */
    protected function addWhereInBinding(Builder $builder, string $column, bool $or, bool $not, string $values)
    {
        $values = explode(',', $values);

        foreach ($values as $key => $value) {
            if ('NULL' === $value) {
                $values[$key] = null;
            }
        }

        $where = $or ? 'orWhere' : 'where';

        $method = $where.($not ? 'NotIn' : 'In');

        $builder->{$method}($column, $values);
    }

    /**
     * Add where between binding to the model query.
     */
    protected function addWhereBetweenBinding(Builder $builder, string $column, bool $or, string $start, string $end)
    {
        $method = $or ? 'orWhereBetween' : 'whereBetween';

        $builder->{$method}($column, [$start, $end]);
    }

    /**
     * Add where basic binding to the model query.
     */
    protected function addWhereBasicBinding(Builder $builder, string $column, bool $or, string $operator, string $value)
    {
        $method = $or ? 'orWhere' : 'where';

        $operator = $operator ?: '=';

        if ('%' === $operator) {
            $operator = 'like';
            $value = "%{$value}%";
        }

        if ('NULL' === $value) {
            $value = null;
        }

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            $value = substr($value, 1, -1);
        }

        $builder->{$method}($column, $operator, $value);
    }
}
