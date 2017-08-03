<?
namespace core;

class DBDriver implements DBDriverInterface 
{
	const FETCH_ONE = 0; // Добавляем константы. Если из БД нужна одна запись, то FETCH_ONE т.е. 0, а если все, то FETCH_ALL т.е. 1.
	const FETCH_ALL = 1;

	private $pdo; 
	public $id; 

	public function __construct(\PDO $pdo) 
	{
		$this->pdo = $pdo;
		$this->id = 'id_message'; 
		
	}

	public function Query($sql, array $obj = [], $fetch = self::FETCH_ALL) // В данный метод мы передаем константу по умолчанию FETCH_ALL т.е. 1.
	{
		$q = $this->pdo->prepare($sql);
		$q->execute($obj);
		
		/* Данные проверки уже не нужны, т.к. все уже сделано на Exception
		if($q->errorCode() != \PDO::ERR_NONE){ 
			$info = $q->errorInfo();
			die($info[2]);
		}*/

		return $fetch === self::FETCH_ALL ? $q->fetchAll() : $q->fetch(); // Если в метод передали FETCH_ALL, то выполняем fetchAll(), т.е. все записи из базы, а иначе выполняем fetch(), т.е. одну запись из базы.
	}
    	                    
	public function Insert($table, array $obj) 
	{
		
		$columns = []; // Создаем два свойства в виде массива.
		$masks = []; 
		
		foreach ($obj as $key => $value) { // После цикла получаем
			$columns[] = $key; // name
			$masks[] = ":$key"; // :name

        
			if ($value === null) {  // Если массив пустой
				$obj[$key] = 'NULL'; // В БД будет занесено 'NULL'
			}
		}

		$columns_s = implode(',', $columns); 
		$masks_s = implode(',', $masks); 
		$query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";
		
		$q = $this->pdo->prepare($query); 
		$q->execute($obj); 

		/*if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }*/

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

		/*if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }*/

        return $q->rowCount(); 
    }

    public function Delete($table, $where)
    {
    	$query = "DELETE FROM $table WHERE {$this->id}=$where"; 

        $q = $this->pdo->prepare($query);
        $q->execute();

        /*if($q->errorCode() != \PDO::ERR_NONE) { 
        	$info = $q->errorInfo();
            exit($info[2]);
        }*/

        return $q->rowCount();
    }





}