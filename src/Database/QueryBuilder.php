<?php
declare(strict_types=1);

namespace EarthCycle\Database;

use PDO;
use PDOStatement;
use InvalidArgumentException;

/**
 * EarthCycle Fluent Query Builder
 * 
 * Provides safe parameterized SQL statement construction with automatic parameter
 * escaping, prepared statement execution, and result mapping.
 * 
 * @package EarthCycle\Database
 */
class QueryBuilder
{
    private PDO $pdo;
    private string $table = '';
    private array $columns = ['*'];
    private array $whereConditions = [];
    private array $bindings = [];
    private array $orderBys = [];
    private ?int $limitCount = null;
    private ?int $offsetCount = null;
    private array $joins = [];

    /**
     * Constructor accepts optional PDO connection
     *
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::getInstance();
    }

    /**
     * Static factory method to begin query on a table
     *
     * @param string $table
     * @param PDO|null $pdo
     * @return self
     */
    public static function table(string $table, ?PDO $pdo = null): self
    {
        $builder = new self($pdo);
        $builder->table = $table;
        return $builder;
    }

    /**
     * Specify column list to select
     *
     * @param array|string $columns
     * @return self
     */
    public function select(array|string $columns = ['*']): self
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Add WHERE equality or comparison clause
     *
     * @param string $column
     * @param mixed $operatorOrValue
     * @param mixed|null $value
     * @return self
     */
    public function where(string $column, mixed $operatorOrValue, mixed $value = null): self
    {
        if ($value === null) {
            $operator = '=';
            $val = $operatorOrValue;
        } else {
            $operator = (string)$operatorOrValue;
            $val = $value;
        }

        $paramKey = ':p_' . count($this->bindings);
        $this->whereConditions[] = "{$column} {$operator} {$paramKey}";
        $this->bindings[$paramKey] = $val;

        return $this;
    }

    /**
     * Add WHERE IN clause
     *
     * @param string $column
     * @param array $values
     * @return self
     */
    public function whereIn(string $column, array $values): self
    {
        if (empty($values)) {
            $this->whereConditions[] = '0 = 1';
            return $this;
        }

        $placeholders = [];
        foreach ($values as $val) {
            $key = ':p_' . count($this->bindings);
            $placeholders[] = $key;
            $this->bindings[$key] = $val;
        }

        $this->whereConditions[] = "{$column} IN (" . implode(', ', $placeholders) . ')';
        return $this;
    }

    /**
     * Add WHERE LIKE clause
     *
     * @param string $column
     * @param string $pattern
     * @return self
     */
    public function whereLike(string $column, string $pattern): self
    {
        $key = ':p_' . count($this->bindings);
        $this->whereConditions[] = "{$column} LIKE {$key}";
        $this->bindings[$key] = $pattern;
        return $this;
    }

    /**
     * Add ORDER BY clause
     *
     * @param string $column
     * @param string $direction ASC or DESC
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $dir = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBys[] = "{$column} {$dir}";
        return $this;
    }

    /**
     * Set LIMIT clause
     *
     * @param int $limit
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->limitCount = max(1, $limit);
        return $this;
    }

    /**
     * Set OFFSET clause
     *
     * @param int $offset
     * @return self
     */
    public function offset(int $offset): self
    {
        $this->offsetCount = max(0, $offset);
        return $this;
    }

    /**
     * Build the raw SELECT query string
     *
     * @return string
     */
    public function toSql(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . " FROM `{$this->table}`";

        if (!empty($this->whereConditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereConditions);
        }

        if (!empty($this->orderBys)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBys);
        }

        if ($this->limitCount !== null) {
            $sql .= " LIMIT {$this->limitCount}";
        }

        if ($this->offsetCount !== null) {
            $sql .= " OFFSET {$this->offsetCount}";
        }

        return $sql;
    }

    /**
     * Execute SELECT query and retrieve all matching records
     *
     * @return array
     */
    public function get(): array
    {
        $stmt = $this->executeStatement();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve single record matching query
     *
     * @return array|null
     */
    public function first(): ?array
    {
        $this->limit(1);
        $stmt = $this->executeStatement();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Count total matching records
     *
     * @param string $column
     * @return int
     */
    public function count(string $column = '*'): int
    {
        $this->columns = ["COUNT({$column}) as total_count"];
        $stmt = $this->executeStatement();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total_count'] ?? 0);
    }

    /**
     * Insert new record into table
     *
     * @param array $data Associative array of column => value
     * @return int Last inserted ID
     */
    public function insert(array $data): int
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Insert data array cannot be empty.");
        }

        $columns = array_keys($data);
        $params = [];
        $placeholders = [];

        foreach ($data as $col => $val) {
            $placeholder = ':' . $col;
            $placeholders[] = $placeholder;
            $params[$placeholder] = $val;
        }

        $sql = "INSERT INTO `{$this->table}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update matching records in table
     *
     * @param array $data
     * @return int Number of affected rows
     */
    public function update(array $data): int
    {
        if (empty($data)) {
            return 0;
        }

        $setClauses = [];
        $params = [];

        foreach ($data as $col => $val) {
            $placeholder = ':upd_' . $col;
            $setClauses[] = "`{$col}` = {$placeholder}";
            $params[$placeholder] = $val;
        }

        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $setClauses);

        if (!empty($this->whereConditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereConditions);
            $params = array_merge($params, $this->bindings);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    /**
     * Delete matching records from table
     *
     * @return int Number of affected rows
     */
    public function delete(): int
    {
        $sql = "DELETE FROM `{$this->table}`";

        if (!empty($this->whereConditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereConditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->rowCount();
    }

    /**
     * Prepare and execute the statement
     *
     * @return PDOStatement
     */
    private function executeStatement(): PDOStatement
    {
        $stmt = $this->pdo->prepare($this->toSql());
        $stmt->execute($this->bindings);
        return $stmt;
    }
}
