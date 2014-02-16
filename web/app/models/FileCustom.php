<?php

class FileCustom extends Eloquent {
	
	//string contains the name of table in the database
	protected $table = "files";
	
	//array of fields which can be filled
	protected $fillable = array("path", "report_id");
	
	//string cotnains the host id column name (game_id, post_id, ...)
	protected $host_id_coulmn_name;
	
	//string cotnains the host id column value (2, 7, ...)
	protected $host_id_column_value;
	
	//string contains the extension of the file
	protected $extension;
	
	static protected function generateRelativePath() {
		
		//string contains the relative path to the root of the application
		$relative_path = "/uploads/" . str_random(3);		
		
		return $relative_path;
	}
	
	
	static protected function generateRealName($name) {
		
		//array contains the name and extension of the file
		$name_extension = explode(".", $name);

		//string contains the file real name (fileName + randomNumber + extension)
		$real_name = $name_extension[0] .  "_" . str_random(15) . "." . end($name_extension);
		
		return $real_name;
	}
	
	static public function getExtenstion($name) {
		//array contains the name and extension of the file
		$name_extension = explode(".", $name);

		//string contains the extension
		$extension = end($name_extension);
		
		return $extension;
	}
	/*
	 * Create File entry in database
	 * params: file object:: file to be uploaded to the server
	 * 		   file type<string> : contains the type of the file to be set in database
	 * 		   file host<key value array> : key contains the column name , value contains the value of that column 
	 * 		   ex : ("game_id" => 4) 
 	 * return: file created(custom file model) : file created in database
	 */ 
	 static public function createFile($file, $file_type, $file_host) {
		
		
		
		//set extension of the file
		$name_extension = explode(".", $file->getClientOriginalName());
				
		//string contains the file real name (fileName + randomNumber + extension)
		$real_name = self::generateRealName($file->getClientOriginalName());
		
		//string contains relative path to the root
		$relative_path = self::generateRelativePath();
		
		//check if file host is set
		if (isset($file_host)) {
			
			foreach ($file_host as $column => $value) {
				//string contains the key which is the column name of the host of this file
				$host_id_coulmn_name = $column;
				//the value of the id
				$host_id_column_value = $value;	
			}
			
			//create a file in database
			$file_created = self::create(array(
				"size" => $file->getSize(),
				"real_name" => $real_name,
				"uploaded_name" => $file->getClientOriginalName(),
				"path" => ($relative_path . "/" . $real_name),
				"type" => $file_type,
				$host_id_coulmn_name => $host_id_column_value
			));
			
			//set file host id column name
			$file_created->host_id_coulmn_name = $host_id_coulmn_name;
			//set file host id column value
			$file_created->host_id_column_value = $host_id_column_value;
		}
		else {
			//set all host with null values
			
			//create a file in database
			$file_created = self::create(array(
				"size" => $file->getSize(),
				"real_name" => $real_name,
				"uploaded_name" => $file->getClientOriginalName(),
				"path" => ($relative_path . "/" . $real_name),
				"type" => $file_type
			));
		}

		return $file_created;
	 }

	/*
	 * Check if the file extension is valid or not
	 * params: file<file input>: file object to be checked
	 * 		   extensions<string array> : all allowed extensions
	 * return: boolean true if valid and false if not
	 */
	 static public function validExtension($file, $allowed_extensions)
	 {
		 return in_array($file->getClientOriginalExtension(), $allowed_extensions);
	 }
	 
	 /*
	 * Get File Path ( URL )
	 * params: void
	 * return: path<string> : path of the file
	 */
	 public function getPath() {
	 	//concatenation of the root http://www.domain.com and relative path /uploads/folder/file
	 	return URL::route("home") . $this->path;
	 }
	 
	/*
	 * Get Folder where the file exists
	 * params: void
	 * return: path<string> : path of the folder
	 */ 
	 public function getFolder() {
	 	//split string by file real name
	 	$parts = explode($this->real_name, $this->path);
		
		return $parts[0];
	 }
	 
}
	