<?php

namespace Core\Database;

use InvalidArgumentException;

class QueryBuilder
{
    private string $columns = '*';

    private array $joins  = [];
    private array $wheres = [];
    private array $params = [];

    private array $groupBy = [];
    private array $orderBy = [];

    private ?int $limit  = null;
    private ?int $offset = null;

    public function __construct(private string $table)
    {
    }

    public function select(string $columns = '*'): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function where(string $condition, array $params = []): static
    {
        $this->wheres[] = $condition;

        $this->params = [
            ...$this->params,
            ...$params
        ];

        return $this;
    }

    public function innerJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, 'INNER');
    }

    public function leftJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, 'LEFT');
    }

    public function rightJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, 'RIGHT');
    }

    private function join(string $table, string $condition, string $type): static
    {
        $this->joins[] =
            "{$type} JOIN {$table} ON {$condition}";

        return $this;
    }

    public function groupBy(string ...$columns): static
    {
        array_push($this->groupBy, ...$columns);

        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $direction = strtoupper($direction);

        $this->orderBy[] = "{$column} {$direction}";

        return $this;
    }

    public function limit(int $limit): static
    {
        if ($limit < 1) {
            throw new InvalidArgumentException('Limit inválido');
        }

        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): static
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('Offset inválido');
        }

        $this->offset = $offset;

        return $this;
    }

    public function query(): string
    {
        $sql = "SELECT {$this->columns} FROM {$this->table}";

        if ($this->joins) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        if ($this->wheres) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }

        if ($this->groupBy) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groupBy);
        }

        if ($this->orderBy) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }

        return $sql;
    }

    public function params(): array
    {
        return $this->params;
    }
}
