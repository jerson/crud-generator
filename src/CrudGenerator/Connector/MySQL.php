<?php
namespace CrudGenerator\Connector;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Index;
use CrudGenerator\Table\Reference;
use CrudGenerator\Table\Table;
use CrudGenerator\Table\Type;

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

            $name = isset($result[0]) ? $result[0] : '';
            $tables[] = $this->getTable($name);
        }

        return $tables;
    }

    /**
     * @inheritdoc
     */
    public function getTable($name)
    {

        $statement = $this->pdo->prepare(sprintf('SHOW FULL COLUMNS FROM %s', $name));

        // TODO corregir no me funciona usando bindParam
        //$statement = $this->pdo->prepare('SHOW FULL COLUMNS FROM :name');
        //$statement->bindParam(':name', $name, \PDO::PARAM_STR);

        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);


        $table = new Table();
        $table->setName($name);

        $references = $this->getReferences($name);
        $indexes = $this->getIndexes($name);

        foreach ($results as $result) {

            $fieldReferences = isset($references[$result['Field']]) ? $references[$result['Field']] : array();

            $fieldIndexes = array();

            foreach ($indexes as $index) {
                $columns = $index->getColumns();
                if (in_array($result['Field'], $columns)) {
                    $fieldIndexes[] = $index;
                }
            }

            $field = new Field();
            $field->setName($this->parseFieldName($result['Field']));
            $field->setType($this->parseFieldType($result['Type']));
            $field->setAllowNull($this->parseFieldAllowNull($result['Null']));
            $field->setKey($this->parseFieldKey($result['Key']));
            $field->setDefault($this->parseFieldDefault($result['Default']));
            $field->setAutoIncrement($this->parseFieldAutoIncrement($result['Extra']));
            $field->setSpecialType($this->parseFieldSpecialType($result['Comment']));
            $field->setComment($this->parseFieldComment($result['Comment']));
            $field->setReferences($fieldReferences);
            $field->setIndexes($fieldIndexes);

            $table->addField($field);
        }

        return $table;
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

            $reference = new Reference();
            $reference->setColumn($result['reference_column']);
            $reference->setTable($result['reference_table']);

            $tableReferences[$column][] = $reference;

        }

        return $tableReferences;

    }

    /**
     * @return string
     */
    protected function getDatabaseName()
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

            if (isset($tableIndexes[$keyName])) {
                $tableIndexes[$keyName]->addColumn($result['Column_name']);
            } else {

                $index = new Index();

                $index->setName($result['Key_name']);
                $index->addColumn($result['Column_name']);
                $index->setCollation($result['Collation']);
                $index->setCardinality($result['Cardinality']);

                $type = $result['Index_type'] === 'BTRE' ? Index::BTREE : Index::UNKNOWN;

                $index->setType($type);
                $index->setUnique($result['Non_unique'] === '0' ? true : false);

                $tableIndexes[$keyName] = $index;

            }

        }


        return $tableIndexes;
    }
}
