<?
namespace core;

class DBDriver implements DBDriverInterface 
{
	private $pdo; 
	public $id; 

	public function __construct(\PDO $pdo) 
	{
		$this->pdo = $pdo;
		$this->id = 'id_message'; 
		
	}

	public function Query($sql)
	{
		$q = $this->pdo->prepare($sql); 
		$q->execute(); 

        if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]); 
        }

          return $q->fetchAll(); 
    }
    	                    
	public function Insert($table, array $obj)
	{
		
		$columns = []; 
		$masks = []; 
		
		foreach ($obj as $key => $value) { 
			$columns[] = $key; 
			$masks[] = ":$key"; 

			if ($value === null) {  
				$obj[$key] = 'NULL'; 
			}
		}

		$columns_s = implode(',', $columns); 
		$masks_s = implode(',', $masks); 
		$query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";
		
		$q = $this->pdo->prepare($query); 
		$q->execute($obj); 

		if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }

        return $this->pdo->lastInsertId();
    }

	public function Update($table, array $obj, $where)
	{

		$sets = []; 
		
		foreach ($obj as $key => $value) { 
			$sets[] = "$key=:$key";

			if ($value === null) {  
				$obj[$key] = 'NULL';
			}
		}

		$sets_s = implode(',', $sets);
		$query = "UPDATE $table SET $sets_s WHERE {$this->id}=$where"; 		
		
		$q = $this->pdo->prepare($query); 
		$q->execute($obj); 

		if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }

        return $q->rowCount(); 
    }

    public function Delete($table, $where)
    {
    	$query = "DELETE FROM $table WHERE {$this->id}=$where"; 

        $q = $this->pdo->prepare($query);
        $q->execute();

        if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }

        return $q->rowCount();
    }





}