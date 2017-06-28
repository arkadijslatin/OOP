<?


namespace core; 

interface DBDriverInterface 
{
	public function __construct(\PDO $pdo); 

	
	public function Query($sql); 

	  
	public function Insert($table, array $obj); 

	
	public function Update($table, array $obj, $where); // Редактируем в БД.

	
	public function Delete($table, $where); // Удаляем из БД. 

}
