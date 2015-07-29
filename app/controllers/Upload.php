<?php

class Upload
{
	protected $file;
	
	public function __construct($file)
	{
		$this->file = $file;
	}

	public function upload()
	{
		if (!is_null($this->file)):
			$destinationPath = 'public/uploads/';
    	  	$extension = $this->file->getClientOriginalExtension();
	    	$fileName = uniqid() .'.'.$extension; 
	    	$this->file->move($destinationPath, $fileName);
	    	return 'uploads/' . $fileName;
	    endif;
	    
	    return null;	
	}
}