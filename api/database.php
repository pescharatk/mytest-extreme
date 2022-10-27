<?php
if (!class_exists('database')) {
	class database {
	
		public $conn;
		
		function __construct() {
		    include '../config/config.php';
            
		    if($environment=="testing"){
                $hostname = "localhost";
                $username  = "root";
                $password = "";
                $database  = "test";
		    }else{
                $hostname = "us-cdbr-east-06.cleardb.net";
                $username  = "b4acded5958781";
                $password = "9f26e3bd";
                $database  = "heroku_083f8ff0a68d8e1";		        
		    }
            
            $hostname = "us-cdbr-east-06.cleardb.net";
                $username  = "b4acded5958781";
                $password = "9f26e3bd";
                $database  = "heroku_083f8ff0a68d8e1";  
			
			$conn = mysqli_connect($hostname,$username,$password,$database) or die ("could not connect to mysql"); 
			mysqli_set_charset($conn,"utf8");	
			$this->conn = $conn;
			
		}

		function query($sql) {
			$this->query = mysqli_query($this->conn, $sql);
			return $this;
		}

		function result() {
		    $resultset = array();
			while ($result = mysqli_fetch_assoc($this->query)) {
				$resultset[] = $result;
			}
            
			if (!empty($resultset)) {
				return json_encode($resultset);
			}
		}
		
		function row() {
			$row = mysqli_fetch_assoc($this->query);

			if (!empty($row)) {
				return json_encode($row);
			}
		}
		
		function num_rows() {
			$num_rows = mysqli_num_rows($this->query);
			return $num_rows;
		}
        
        function insert_id() {
            $insert_id = mysqli_insert_id($this->conn);
            return $insert_id;
        }
        
        function error($show=1){
            if(mysqli_error($this->conn)) {
                if($show==2){
                    return true;
                }else{
                    echo ("Error description: " . mysqli_error($this->conn));
                    return true;
                }
             }
        }
	}

}
?>	
