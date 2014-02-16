<?php

/**
* PDO SINGLETON CLASS
*/
class db
{
    /**
* The singleton instance
*
*/
    static private $PDOInstance;
	static private $Instance;
	static private $statement;
	//private $sql_debug='';
	private $debug_str='SQL_NO_CACHE';
	private $sql_debug=0;
     
   /**
* Creates a PDO instance representing a connection to a database and makes the instance available as a singleton
*
* @param string $dsn The full DSN, eg: mysql:host=localhost;dbname=testdb
* @param string $username The user name for the DSN string. This parameter is optional for some PDO drivers.
* @param string $password The password for the DSN string. This parameter is optional for some PDO drivers.
* @param array $driver_options A key=>value array of driver-specific connection options
*
* @return PDO
*/
    static function init()
    {
       if(!self::$Instance) {
			try {
			$ini_array = parse_ini_file("config/config.ini");
			$driver_options=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
			self::$PDOInstance = new PDO("mysql:host=".$ini_array['host'].";dbname=".$ini_array['dbname']."", $ini_array['username'], $ini_array['password'], $driver_options);
			self::$Instance=new db;
			} catch (PDOException $e) {
			die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
	   }
       return self::$Instance;
    }

   /**
* Initiates a transaction
*
* @return bool
*/
public function beginTransaction() {
return self::$PDOInstance->beginTransaction();
}
        
/**
* Commits a transaction
*
* @return bool
*/
public function commit() {
return self::$PDOInstance->commit();
}

/**
* Fetch the SQLSTATE associated with the last operation on the database handle
*
* @return string
*/
    public function errorCode() {
     return self::$PDOInstance->errorCode();
    }
    
    /**
* Fetch extended error information associated with the last operation on the database handle
*
* @return array
*/
    public function errorInfo() {
     return self::$PDOInstance->errorInfo();
    }
    
    /**
* Execute an SQL statement and return the number of affected rows
*
* @param string $statement
*/
    public function exec($statement) {
    	 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 
    	 $Q=self::$PDOInstance->exec($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else
		 {
		 	 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
		 }
			 return $Q;
	}
    
    /**
* Retrieve a database connection attribute
*
* @param int $attribute
* @return mixed
*/
    public function getAttribute($attribute) {
     return self::$PDOInstance->getAttribute($attribute);
    }

    /**
* Return an array of available PDO drivers
*
* @return array
*/
    public function getAvailableDrivers(){
     return Self::$PDOInstance->getAvailableDrivers();
    }
    
    /**
* Returns the ID of the last inserted row or sequence value
*
* @param string $name Name of the sequence object from which the ID should be returned.
* @return string
*/
public function lastInsertId($name=null) {
return self::$PDOInstance->lastInsertId($name);
}
        
    /**
* Prepares a statement for execution and returns a statement object
*
* @param string $statement A valid SQL statement for the target database server
* @param array $driver_options Array of one or more key=>value pairs to set attribute values for the PDOStatement obj
returned
* @return PDOStatement
*/
    public function prepare ($statement, $driver_options=false) {
     if(!$driver_options) $driver_options=array();
     return self::$PDOInstance->prepare($statement, $driver_options);
    }
    
    /**
* Executes an SQL statement, returning a result set as a PDOStatement object
*
* @param string $statement
* @return PDOStatement
*/
    public function query($statement) {
       if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip()))
	   echo "<!--".$statement."
-->";
       $Q=self::$PDOInstance->query($statement);
	   $E=self::$PDOInstance->errorInfo();
	   if(isset($E[1])){
		   $E[]=$statement;
			tools::print_r($E);
	   }
	   else
	   return $Q; 
	}
	
/**
* Execute query and return all rows in assoc array
*
* @param string $statement
* @return array
*/
    public function queryFetchAllAssoc($statement) {
	    if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		}
		 
		 $Q=self::$PDOInstance->query($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else{
		 $result=$Q->fetchAll(PDO::FETCH_ASSOC);
			 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
		 return $result;
		 }
	}
     public function queryFetchAllObj($statement) {
        if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
         $mtime = microtime();
         $mtime = explode(" ",$mtime);
         $mtime = $mtime[1] + $mtime[0];
         $starttime = $mtime;
         $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
        }
         
         $Q=self::$PDOInstance->query($statement);
         $E=self::$PDOInstance->errorInfo();
         if(isset($E[1])){
             $E[]=$statement;
             tools::print_r($E);
         }else{
         $result=$Q->fetchAll(PDO::FETCH_OBJ);
             if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
             $mtime = microtime();
             $mtime = explode(" ",$mtime);
             $mtime = $mtime[1] + $mtime[0];
             $endtime = $mtime;
             $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
             }
         return $result;
         }
    }
	public function queryFetchAll($statement) {
	    if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		}
		 
		 $Q=self::$PDOInstance->query($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else{
		 $result=$Q->fetchAll(PDO::FETCH_NUM);
		if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
		 return $result;
		 }
	}
	public function queryFetchAllFirst($statement) {
		 //$this->statement=$statement
		 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $starttime = $mtime;
			 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		 }
		 
		 $Q=self::$PDOInstance->query($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else{
			 $result=$Q->fetchAll(PDO::FETCH_COLUMN, 0);
		 	 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
			 return $result;
		 }
	}
    public function queryFetchFirst($statement) {
        //$this->statement=$statement
        if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
            $mtime = microtime();
            $mtime = explode(" ",$mtime);
            $mtime = $mtime[1] + $mtime[0];
            $starttime = $mtime;
            $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
        }

        $Q=self::$PDOInstance->query($statement);
        $E=self::$PDOInstance->errorInfo();
        if(isset($E[1])){
            $E[]=$statement;
            tools::print_r($E);
        }else{
            $result=$Q->fetch(PDO::FETCH_COLUMN, 0);
            if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $totaltime = ($endtime - $starttime);
                echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
            }
            return $result;
        }
    }
	 public function queryFetchRow($statement) {
	 	if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		}
		
	 	 $Q=self::$PDOInstance->query($statement);
		 $E=self::$PDOInstance->errorInfo();
		  if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else{
		 	 $result=$Q->fetch(PDO::FETCH_ASSOC);
		 	 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
		 }
			return $result;
    }
    public function queryFetchObj($statement) {
        if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
         $mtime = microtime();
         $mtime = explode(" ",$mtime);
         $mtime = $mtime[1] + $mtime[0];
         $starttime = $mtime;
         $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
        }
        
         $Q=self::$PDOInstance->query($statement);
         $E=self::$PDOInstance->errorInfo();
          if(isset($E[1])){
             $E[]=$statement;
             tools::print_r($E);
         }else{
             $result=$Q->fetch(PDO::FETCH_OBJ);
             if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
             $mtime = microtime();
             $mtime = explode(" ",$mtime);
             $mtime = $mtime[1] + $mtime[0];
             $endtime = $mtime;
             $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
             }
         }
            return $result;
    }
    /**
* Execute query and return one row in assoc array
*
* @param string $statement
* @return array
*/
    public function queryFetchRowAssoc($statement) {
    	if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		}
		 
    	 $Q=self::$PDOInstance->query($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if(isset($E[1])){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else{
		 	$result=$Q->fetch(PDO::FETCH_ASSOC);
		 	if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
		 }
			 return $result;
    }
    
    /**
* Execute query and select one column only
*
* @param string $statement
* @return mixed
*/
    public function queryFetchColAssoc($statement) {
    	 if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 $statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
		}
     $result=self::$PDOInstance->query($statement)->fetchColumn();
	 	if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			 $mtime = microtime();
			 $mtime = explode(" ",$mtime);
			 $mtime = $mtime[1] + $mtime[0];
			 $endtime = $mtime;
			 $totaltime = ($endtime - $starttime);
echo "
<!--".$statement."
Exec time: ".round($totaltime,4)." seconds
-->
";
		 	 }
	 return $result;
    }
    
    /**
* Quotes a string for use in a query
*
* @param string $input
* @param int $parameter_type
* @return string
*/
    public function quote ($input, $parameter_type=0) {
     return self::$PDOInstance->quote($input, $parameter_type);
    }
    
    /**
* Rolls back a transaction
*
* @return bool
*/
    public function rollBack() {
     return self::$PDOInstance->rollBack();
    }
    
    /**
* Set an attribute
*
* @param int $attribute
* @param mixed $value
* @return bool
*/
    public function setAttribute($attribute, $value ) {
     return self::$PDOInstance->setAttribute($attribute, $value);
    }
	public function debug(){
		
	}
	public function startdebug(){
		if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			$mtime = microtime();
			$mtime = explode(" ",$mtime);
			$mtime = $mtime[1] + $mtime[0];
			$starttime = $mtime;
			$this->statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
			$this->starttime=$starttime;
		}	
	}
	public function enddebug(){
		if(!tools::IsAjaxRequest() && $this->sql_debug==1 && in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
			$mtime = microtime();
			$mtime = explode(" ",$mtime);
			$mtime = $mtime[1] + $mtime[0];
			$starttime = $mtime;
			$this->statement=str_replace('SELECT', 'SELECT sql_no_cache ', $statement);
			$this->starttime=$starttime;
		}	
	}
	
}
?>