<?php

namespace Zeretei\PHPCore\Blueprint;

use Zeretei\PHPCore\Application;

abstract class Model
{
    /**
     * Database table name
     */
    protected string $table;

    /**
     * Fillable inputs
     */
    protected array $fillable = [];

    /**
     * SQL where selector key
     */
    protected string $key = 'id';

    public function __construct()
    {
        // set table
        if (!isset($this->table)) {
            $this->table = $this->getBaseClassname() . 's';
        }
    }

    /**
     * Execute SQL Insert statement
     */
    public function insert(array $params): bool
    {
        // filter request with $fillable
        $params = $this->filter($params);

        // set column names
        $columns = implode(',', array_keys($params));

        // set column values placeholder
        $values = trim(str_repeat('?,', count($params)), ',');

        // sql statement
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            $columns,
            $values
        );

        return Application::get('database')->query($sql, array_values($params));
    }

    // public function update($params): bool
    // {
    // }

    // public function delete($params): bool
    // {
    // }

    // public function select($params): array|false
    // {
    // }

    // public function all(): array
    // {
    // }

    /**
     * Filter $request with $this->fillable
     * Returns all request that can be filled
     */
    protected function filter(array $params): array
    {
        if (empty($this->fillable)) {
            throw new \Exception('$fillable must have a value.');
        }

        return array_filter(
            // request
            $params,

            // arrow function | return fillable requests
            fn ($_, $key) => in_array($key, $this->fillable),

            // use array keys & values
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * Get base classname
     */
    protected function getBaseClassname(): string
    {
        $class = get_called_class();
        $base = basename(str_replace('\\', DIRECTORY_SEPARATOR, $class));
        return  strtolower($base);
    }
}
