<?php
/*
 * Copyright 2014 by Balthazar3k
 */
class Upload {
    
    protected $path;
    
    protected $name;
    
    protected $pattern;
    
    protected $file;
    
    protected $file_type;
    
    protected $status = false;
    
    protected $errors = array();

    public function path($path){
        $this->path = (string) $path;
        return $this;
    }
    
    public function name($name){
        $this->name = (string) $name;
        return $this;
    }
    
    public function type(){
        $this->pattern = (string) "/(\.". implode('|\.', func_get_args()).")/i";
        return $this;
    }
    
    public function init(){
        if( isset( $_FILES ) ) {
            foreach($_FILES as $key => $val){

                if( $val['size'] < 0 ){
                    $this->errors[] = 'die Datei ist Leer';
                    return null;
                }

                preg_match($this->pattern, $val['name'], $res);

                if( count($res) == 0 ){
                    $this->file_type = $res[1];
                    $this->status = false;
                    $this->errors[] = 'falscher datei type!';
                    return null;
                }


                if(empty($this->name) ){
                    $this->name = time() . $res[1];
                } else {
                    $this->name .= $res[1];
                }

                if(move_uploaded_file($val['tmp_name'], $this->path.$this->name)){
                    $this->status = true;
                    $this->file = $this->path.$this->name;
                    return true;
                } else {
                    $this->status = false;
                    return null;
                }

            }
        }
    }
    
    public function file(){
        return $this->file;
    }
    
    public function status(){
        return $this->status;
    }
    
    public function errors(){
        return implode('', $this->errors);
    }
        
}
?>