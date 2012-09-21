<?php 
class Database extends mysqli {
	const DBHOST = 'localhost';
	const DBUSER = 'pro';
	const DBPASS = 'pro0011'; 
	const DB = 'pro_one_task';
	

	/**
	 * calls parent contructor using arguemnts DBHOST, DBUSER, DBPASS, DB
	 *
	 */
	public function __construct(){
		parent::__construct(self::DBHOST, self::DBUSER, self::DBPASS, self::DB);
    }

    /**
     * Returns a mysql escaped string or false upon failure
     * @param mysql string
     * @return mixed escaped string
     */
    public function escape_string($entry){
        return $this->real_escape_string($entry);
    }
	
	
	/**
	 * Returns the selection specified by the table. column, and options where
	 * parameters.
	 * @param string $table
	 * @param string $columns
	 * @param string $where
	 */
	public function select($table, $columns, $where = ''){
		$query = sprintf("select %s from %s", $columns, $table);
		
		if(!empty($where)){
			$query .= sprintf(" where %s", $where);
		}
		
        $result = $this->query($query);

        if(empty($result)){
            return array();
        }

        $num_rows = $result->num_rows;
		if(empty($num_rows)){
			return array();
		}

		for($i = 0; $i < $num_rows; ++$i){
			$rows[$i] = $result->fetch_array(MYSQL_ASSOC);
		}
		
		return $rows;
	}

    /**
     * Inserts row_values into the database.
     * Note: $row_values must be an array, whereby
     * the keys correspond to the table column name(s),
     * and the value corresponds to to value to be inserted.
     *
     * $row_values('column_name'=>'column_value');
     *
     * @param string $table table name
     * @param array $row_values values to insert
     * @return integer
     */
	public function insert($table, array $row_values){
		if(empty($row_values)){
			return false;
		}
		
		$columns = array_keys($row_values);
		$values = array_values($row_values);

		// escape entries
		foreach($values as $key=>$value){
			$values[$key] = $this->escape_string($value);
		}
		
		$table_columns = "(". implode(", " , $columns).")";
		$column_values = "('".implode("', '", $values)."')";

		
		$query = sprintf("insert into %s %s values %s", $table, $table_columns, $column_values);

		return $this->query($query);
	}
	
	/**
	 * Update the table by setting the $set fields qualified
	 * by the $where string.
	 * @param string $table
	 * @param string $set
	 * @param string $where
	 */
	public function update($table, $set, $where){
		$query = sprintf("update %s set %s where %s", $table, $set, $where);
		
		return $this->query($query);	
	}
	
	
}
