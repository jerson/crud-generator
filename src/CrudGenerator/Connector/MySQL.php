<?php
namespace CrudGenerator\Connector;


use CrudGenerator\Table\Table;
use CrudGenerator\Table\TableType;

class MySQL extends BaseConnector implements ConnectorInterface
{

    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritdoc
     */
    public function getTables()
    {
        $statement = $this->pdo->query('SHOW TABLES');
        $results = $statement->fetchAll();
        $tables = array();

        foreach ($results as $result) {
            $tables[] = isset($result[0]) ? $result[0] : '';
        }

        return $tables;
    }

    /**
     * @inheritdoc
     */
    public function getTable($name)
    {

        $statement = $this->pdo->prepare(sprintf('SHOW COLUMNS FROM %s', $name));

        // TODO corregir no me funciona usando bindParam
        //$statement = $this->pdo->prepare('SHOW COLUMNS FROM :name');
        //$statement->bindParam(':name', $name, \PDO::PARAM_STR);

        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $tableProperties = array();

        foreach ($results as $result) {

            $table = new Table();
            $table->setField($this->parseField(isset($result['Field']) ? $result['Field'] : ''));
            $table->setType($this->parseType(isset($result['Type']) ? $result['Type'] : ''));
            $table->setAllowNull($this->parseAllowNull(isset($result['Null']) ? $result['Null'] : ''));
            $table->setKey($this->parseKey(isset($result['Key']) ? $result['Key'] : ''));
            $table->setDefault($this->parseDefault(isset($result['Default']) ? $result['Default'] : ''));
            $table->setAutoIncrement($this->parseAutoIncrement(isset($result['Extra']) ? $result['Extra'] : ''));
            $table->setReferences($this->getReferences($name));
            $table->setIndexes($this->getIndexes($name));

            $tableProperties[] = isset($result[0]) ? $result[0] : '';
        }

        return $tableProperties;
    }

    /**
     * @return string
     */
    protected  function getDatabaseName()
    {
        $statement = $this->pdo->query('SELECT DATABASE()');
        $statement->execute();

        return $statement->fetchColumn(0);
    }

    /**
     * @inheritdoc
     */
    public function getIndexes($name)
    {

        $statement = $this->pdo->prepare(sprintf('SHOW INDEX FROM %s', $name));

        // TODO corregir no me funciona usando bindParam
        //$statement = $this->pdo->prepare('SHOW INDEX FROM \':name\'');
        //$statement->bindParam(':name', $name, \PDO::PARAM_STR);

        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $tableIndexes = array();

        foreach ($results as $result) {

            $keyName = $result['Key_name'];

            $tableIndexes[$keyName][] = array(
                'name' => $result['Key_name'],
                'sequence' => $result['Seq_in_index'],
                'column' => $result['Column_name'],
                'collation' => $result['Collation'],
                'cardinality' => $result['Cardinality'],
                'type' => $result['Index_type'],
                'unique' => $result['Non_unique'] === '0' ? true : false,
            );

        }


        return $tableIndexes;
    }

    /**
     * @inheritdoc
     */
    public function getReferences($name)
    {


        $query = <<<'SQL'
select
    column_name as 'column',
    referenced_table_name as 'reference_table',
    referenced_column_name as 'reference_column'
from
    information_schema.key_column_usage
where
    referenced_table_name is not null
    and table_schema = :database
    and table_name = :table

SQL;

        $database = $this->getDatabaseName();
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':table', $name, \PDO::PARAM_STR);
        $statement->bindParam(':database', $database, \PDO::PARAM_STR);

        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $tableReferences = array();

        foreach ($results as $result) {

            $column = $result['column'];

            $tableReferences[$column][] = array(
                'table' => $result['reference_table'],
                'column' => $result['reference_column'],
            );

        }

        return $tableReferences;

    }

}