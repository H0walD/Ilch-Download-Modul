<?php
/*
 * Copyright 2014 by Balthazar3k
 */

class Image {
    protected $file;
    protected $name;
    protected $type;
    protected $path;
    protected $exte;
    
    protected $newPath = NULL;
    protected $newName = NULL;
    
    protected $height;
    protected $width;
    
    protected $resolution;

    protected $exists = false;
    protected $error = array();

    public function source($file){
        if( file_exists($file) ){
            $this->file = $file;
            $res = pathinfo($this->file);
            $this->name = $res['filename']; // evt. erst ab PHP 5.2.0 (Muss man Testen)
            $this->path = $res['dirname'];
            $this->exte = '.'.$res['extension'];
            $res = getimagesize($file);
            $this->type = $res[2];
            $this->width = $res[0];
            $this->height = $res[1];
            $this->exists = true;
        } else {
            $this->error[] = 'Datei exestiert nicht!';
        }
        return $this;
    }
    
    public function width($res){
        if( count($this->resolution['height']) == 0 ){
            $this->resolution['width'] = (array) $res;
        } else {
            $this->error[] = 'H&oumlhe wurde schon definiert!';
        }
        
        return $this;
    }   
    public function height($res){
        if( count($this->resolution['width']) == 0 ){
            $this->resolution['height'] = (array) $res;
        } else {
            $this->error[] = 'Breite wurde schon definiert!';
        }
        
        return $this;
    }
    
    //$image->source()->height(array(300,600,800,1024))->thumbnails();
    public function thumbnails(){
        if( !$this->exists ) : return; endif;
        $this->thumbnail_calc_resolutions();
        $image = $this->imagecreatefrom();
        
        foreach ($this->resolution['width'] as $id => $width ){
            
            $height = $this->resolution['height'][$id];
            if ( function_exists ( 'imagecreatetruecolor' ) ){
                $new_image = imagecreatetruecolor($width, $height);
            }else{
                $new_image = imagecreate($width, $height);
            }
            
            imagecopyresampled(
                $new_image, 
                $image, 
                0, 0, 0, 0,
                $width, 
                $height,
                $this->width,
                $this->height
            );
            
            $file = $this->path.'/';
            $file .= $this->name;
            //$file .= '-'.$width.'x'.$height;
            $file .= '-'.$id;
            $file .= $this->exte;
            
            $this->imagesave($new_image, $file);           
            imagedestroy($new_image);
        }
        
        imagedestroy($image);
    }
    
    private function thumbnail_calc_resolutions(){
        if( is_array($this->resolution['width'] ) ) {
            foreach( $this->resolution['width'] as $id => $width ){
                $this->resolution['height'][$id] = intval($this->height*$width/$this->width);
            }
        }
        
        if( is_array($this->resolution['height'] ) ) {
            foreach( $this->resolution['height'] as $id => $width ){
                $this->resolution['width'][$id] = intval($this->width*$width/$this->height);
            }
        }
    }

    public function convert2gif( $quality = 9 ){
        if( $this->type != 1 && $this->exists ){

            $output = '';
            
            if( empty($this->newPath) ){
                $this->newPath = $this->path;
            }
            
            if( empty($this->newName) ){
                $this->newPath = $this->name;
            }
            
            $image = $this->imagecreatefrom();
            imagegif($image, $this->path.'/'.$this->name.'.gif', $quality);
            imagedestroy($image);
            @unlink($this->file);
        }
    }   
    public function convert2jpg( $quality = 9 ){
        if( $this->type != 2 && $this->exists ){

            $output = '';
            
            if( empty($this->newPath) ){
                $this->newPath = $this->path;
            }
            
            if( empty($this->newName) ){
                $this->newPath = $this->name;
            }
            
            $image = $this->imagecreatefrom();
            imagejpeg($image, $this->path.'/'.$this->name.'.jpg', $quality);
            imagedestroy($image);
            @unlink($this->file);
        }
    }   
    public function convert2png( $quality = 9 ){
        if( $this->type != 3 && $this->exists ){

            $output = '';
            
            if( empty($this->newPath) ){
                $this->newPath = $this->path;
            }
            
            if( empty($this->newName) ){
                $this->newPath = $this->name;
            }
            
            $image = $this->imagecreatefrom();
            imagepng($image, $this->path.'/'.$this->name.'.png', $quality);
            imagedestroy($image);
            @unlink($this->file);
        }
    }
    
    protected function imagecreatefrom(){
        switch($this->type) {
            case 1: return imagecreatefromgif($this->file); break;
            case 2: return imagecreatefromjpeg($this->file); break;
            case 3: return imagecreatefrompng($this->file); break;
            case 4: return imagecreatefromswf($this->file); break;
        }
    }
    
    protected function imagesave($image, $file){
        switch($this->type) {
            case 1: return imagegif($image, $file); break;
            case 2: return imagejpeg($image, $file); break;
            case 3: return imagepng($image, $file); break;
        }
    }
    
    public static function thumb($id, $path){
        $res = pathinfo($path);
        $thumb = $res['dirname'].'/'.$res['filename'].'-'.$id.'.'.$res['extension'];
        if( file_exists($thumb) ) {
            return $thumb;
        } else {
            return 'include/images/downcats/na-'.$id.'.png';
        }
    }
    
    public static function copyright(){
        echo "<br style='clear: both;' /><center>&copy; <small>2014 by <a href='http://balthazar3k.howald-design.ch/'>Angelo.b3k</a> & <a href='http://howald-design.ch/'>H0walD</a> (Download Modul)</small></center>";
    }
}
?>