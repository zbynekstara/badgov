<?php

class FileImage extends FileCustom {
	
	
	//integer contains the width of the image
	public $width = 1;
	
	//integer contains the height of the image
	public $height = 1;
	
	/*
	 * move Image file to server
	 * * params: file object:: file to be uploaded to the server
	 * 		     file type<string> : contains the type of the file to be set in database
	 * 		  	 file host<key value array> : key contains the column name , value contains the value of that column 
	 * 		   	ex : ("game_id" => 4) 
	 * 		   quality<integer> : number takes from 0 to 100 state the quality of the image to be moved
	 * return: file created(custom file model) : file created in database
	 */
	 static public function createImage($file, $file_type, $quality, $file_host = null) {
	 	//create database entry for the file
	 	$image_created = self::createFile($file, $file_type, $file_host);
		
		$full_path = base_path() . "/public/uploads/";
		
		$file->move($full_path, $image_created->real_name);
		
		return $image_created;
		
	 }
	  
	/*
	 * make thumbnail of image
	 * params: new width<integer> : number stating the new width of the image thumbnail
	 * 		   new height<integer> : number stating the new height of the image thumbnail
	 * return: file(file image model) : current file object
	 */
	 public function makeThumbnail($new_width, $new_height)  {
	 	
	 	//set width, height
        //list the object::original image width and height
        list($this->width, $this->height) = getimagesize($this->getPath());
		
		//float contains the current object scale ratio of the width to the height
        $curr_img_scale_ratio = $this->width / $this->height;
        
        //float contains the new scale ratio of the width to the height
        $new_img_scale_ratio = $new_width / $new_width;
        
        //compare the new scale ratio to the current one
        
        //if the new scale ratio is bigger means that new width is much higher and doesn't fit the new height
        if ($new_img_scale_ratio != $curr_img_scale_ratio) {
            //resize the new height make it bigger to keep the scale ratio
            $new_height = (int)($new_width / $curr_img_scale_ratio);
        }
		else {
			//resize the new width make it bigger to keep the scale ratio
            $new_width = (int)($new_height * $curr_img_scale_ratio);
		}
        
        //make an image resource from the current image file
        $curr_img_resource = imagecreatefromjpeg( (base_path() . $this->path) );
        
        //create a black image resouce
        $black_img_resource = imagecreatetruecolor($new_width, $new_height);
        
        //resample the black image to the current image but by changing width and height of the black image in the new resampled form like the current image
        imagecopyresampled($black_img_resource, $curr_img_resource, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
		
		
		$thumbnail_name = self::generateRealName($this->uploaded_name);
		
		$relative_path = $this->getFolder() . "/" . $thumbnail_name;
		
		//string contains full path
		$full_path = base_path() . $relative_path;
		
		//make a copy of the image resource to the generated folder
        imagejpeg($black_img_resource, $full_path, 80);
        
		if (isset($this->host_id_coulmn_name) && isset($this->host_id_column_value)) {
			//create a file in database
			$file_created = self::create(array(
				"size" => filesize($full_path),
				"real_name" => $thumbnail_name,
				"uploaded_name" => $this->uploaded_name,
				"path" => $relative_path,
				"type" => "thumbnail",
				$this->host_id_coulmn_name => $this->host_id_column_value
			));
		}
		else {
			//create a file in database
			$file_created = self::create(array(
				"size" => filesize($full_path),
				"real_name" => $thumbnail_name,
				"uploaded_name" => $this->uploaded_name,
				"path" => $relative_path,
				"type" => "thumbnail"
			));
		}
		
		
		return $this;
		
	 }
	 
}
	