<?php

namespace Core\Database;

use PDO;
use PDOStatement;

class QueryExecutor
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly int $fetchMode = PDO::FETCH_OBJ
    ) {
    }

    public function one(QueryBuilder $builder): object|false
    {
        $builder->limit(1);

        $stmt = $this->prepare($builder->query(), $builder->params());

        $stmt->execute();

        return $stmt->fetch($this->fetchMode);
    }

    public function all(QueryBuilder $builder): array
    {
        $stmt = $this->prepare($builder->query(), $builder->params());

        $stmt->execute();

        return $stmt->fetchAll($this->fetchMode);
    }

    public function lastInsertId(): string|false
    {
        return $this->pdo->lastInsertId();
    }

    public function execute(string $query, array $params): bool
    {
        return $this->prepare($query, $params)->execute();
    }

    private function prepare(string $query, array $params): PDOStatement
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => $value) {
            $param = is_int($key) ? $key + 1 : ':' . ltrim($key, ':');
            $stmt->bindValue($param, $value, $this->getParamType($value));
        }

        return $stmt;
    }

    /**
     * Determina tipo PDO para binding seguro
     *
     * @param mixed $value
     * @return int
     */
    private function getParamType(mixed $value): int
    {
        if (is_bool($value)) {
            return PDO::PARAM_BOOL;
        }

        if (is_int($value)) {
            return PDO::PARAM_INT;
        }

        if (is_null($value)) {
            return PDO::PARAM_NULL;
        }

        return PDO::PARAM_STR;
    }
}
