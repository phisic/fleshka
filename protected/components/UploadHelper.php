<?php

class UploadHelper {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;
    private $handle_type = ''; // handle type post or XMLHttpRequest
    public $ext;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            //$this->file = new qqUploadedFileXhr();
            $this->handle_type = 'XMLHttpRequest';
        } elseif (isset($_FILES['qqfile'])) {
            //$this->file = new qqUploadedFileForm();
            $this->handle_type = 'post';
        } else {
            $this->handle_type = '';
            //$this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        /*
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        } 
         */       
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }

    // sanitize file_name (without extenstion) (adham)
    function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
                (function_exists('mb_strtolower')) ?
                        mb_strtolower($clean, 'UTF-8') :
                        strtolower($clean)  :
                $clean;
    }
    
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        
        //if (!$this->file){
        if ($this->handle_type==''){
            return array('error' => 'No files were uploaded.');
        }

        //$size = $this->file->getSize();
        
        if ($this->handle_type=='post') {
            $size = $this->getSizePost();
            $f_name = $this->getNamePost();
        } else {
            $size = $this->getSizeXml();
            $f_name = $this->getNameXml();
        }
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        //$pathinfo = pathinfo($this->file->getName());
        $pathinfo = pathinfo($f_name);
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $filename = $this->sanitize($filename);
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }

        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 999);
            }
        }

        if ($this->handle_type=='post') {
            $result = $this->savePost($uploadDirectory . $filename . '.' . $ext);
        } else {
            $result = $this->saveXml($uploadDirectory . $filename . '.' . $ext);
        }
        
        if ($result){
            return array('success'=>true, 'filename'=>$filename . '.' . $ext);
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    

    function returnContent(){

        //if (!$this->file){
        if ($this->handle_type==''){
            return array('error' => 'No files were uploaded.');
        }

        if ($this->handle_type=='post') {
            $size = $this->getSizePost();
            $f_name = $this->getNamePost();
        } else {
            $size = $this->getSizeXml();
            $f_name = $this->getNameXml();
        }
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($f_name);
        $filename = $pathinfo['filename'];
        $filename = $this->sanitize($filename);
        $ext = $pathinfo['extension'];

        $this->ext = $ext;

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }

        if ($this->handle_type=='post') {
            $result = $this->getContentPost();
        } else {
            $result = $this->getContentXml();
        }
        
        return $result;        
    }    

    function saveXml($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSizeXml()){
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }

    function getSizeXml() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }

    function getNameXml() {
        return $_GET['qqfile'];
    }

    function getContentXml()
    {
        $input = fopen("php://input", "r");

        $content = '';
        while (($buffer = fgets($input, 4096)) !== false) {
                $content .= $buffer;
            }  

        fclose($input);     
        return $content; 
    }

    function savePost($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }

    function getSizePost() {
        return $_FILES['qqfile']['size'];
    }

    function getNamePost() {
        return $_FILES['qqfile']['name'];
    }

    function getContentPost() {
        return $_FILES['qqfile']['content'];
    }

}

?>