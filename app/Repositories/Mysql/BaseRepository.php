<?php

namespace App\Repositories\Mysql;

use Core\Database\QueryBuilder;
use Core\Database\QueryExecutor;

abstract class BaseRepository
{
    protected string $table;

    public function __construct(protected QueryExecutor $executor)
    {
    }

    protected function builder(): QueryBuilder
    {
        return new QueryBuilder($this->table);
    }

    protected function insert(array $data): int
    {
        $columns = implode(', ', array_keys($data));

        $placeholders = ':' . implode(', :', array_keys($data));

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            $columns,
            $placeholders
        );

        $this->executor->execute($query, $data);

        return (int) $this->executor->lastInsertId();
    }

    protected function update(int $id, array $data): bool
    {
        $fields = [];

        foreach (array_keys($data) as $column) {
            $fields[] = "{$column} = :{$column}";
        }

        $query = sprintf(
            'UPDATE %s SET %s WHERE id = :id',
            $this->table,
            implode(', ', $fields)
        );

        $data['id'] = $id;

        return $this->executor->execute($query, $data);
    }

    protected function delete(string $terms, array $params = []): bool
    {
        $query = sprintf(
            'DELETE FROM %s WHERE %s',
            $this->table,
            $terms
        );

        return $this->executor->execute($query, $params);
    }
}
