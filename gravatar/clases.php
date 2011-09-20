<?php
class Gravatar 
{ 
    /** 
     *    Direccion que generara el avatar 
     */ 
    const GRAVATAR_URL = "http://www.gravatar.com/avatar.php"; 

    /** 
     *    Posibles filtros de adulto 
     */ 
    private $GRAVATAR_RATING = array("G", "PG", "R", "X"); 
     
    /** 
     *    Asociacion de los valores a las variable (para costruir el link) 
     */ 
    protected $properties = array( 
        "gravatar_id"    => NULL, 
        "default"        => NULL, 
        "size"            => 80,        // Ponemos por defecto la dimension de 80pixels 
        "rating"        => NULL, 
        "border"        => NULL, 
    ); 

    /** 
     *    Direccion del avatar que sera convertida a md5
     */ 
    protected $email = ""; 

    /** 
     *    Variables que contiene los atributos de la imagen que se creara del avatar
     */ 
    protected $extra = ""; 

    /** 
     *     
     */ 
    public function __construct($email=NULL, $default=NULL) { 
        $this->setEmail($email); 
        $this->setDefault($default); 
    } 

    /** 
     *     
     */ 
    public function setEmail($email) { 
        
            $this->email = $email; 
            $this->properties['gravatar_id'] = md5(strtolower($this->email)); 
            return true; 
    } 

    /** 
     *     
     */ 
    public function setDefault($default) { 
        $this->properties['default'] = $default; 
    } 

    /** 
     *     
     */ 
    public function setRating($rating) { 
        if (in_array($rating, $this->GRAVATAR_RATING)) { 
            $this->properties['rating'] = $rating; 
            return true; 
        } 
        return false; 
    } 

    /** 
     *     
     */ 
    public function setSize($size) { 
        $size = (int) $size; 
        if ($size <= 0) 
            $size = NULL;        // Use the default size 
        $this->properties['size'] = $size; 
    } 

    /** 
     *     
     */ 
    public function setExtra($extra) { 
        $this->extra = $extra; 
    } 

    /** 
     *     
     */ 
    public function isValidEmail($email) { 
        return preg_replace("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email); 
    } 

    /** 
     *    Object property overloading 
     */ 
    public function __get($var) { return @$this->properties[$var]; } 

    /** 
     *    Object property overloading 
     */ 
    public function __set($var, $value) { 
        switch($var) { 
            case "email":    return $this->setEmail($value); 
            case "rating":    return $this->setRating($value); 
            case "default":    return $this->setDefault($value); 
            case "size":    return $this->setSize($value); 
            // Cannot set gravatar_id 
            case "gravatar_id": return; 
        } 
        return @$this->properties[$var] = $value; 
    } 

    /** 
     *    Object property overloading 
     */ 
    public function __isset($var) { return isset($this->properties[$var]); } 

    /** 
     *    Object property overloading 
     */ 
    public function __unset($var) { return @$this->properties[$var] == NULL; } 

    /** 
     *    Get source 
     */ 
    public function getSrc() { 
        $url = self::GRAVATAR_URL ."?"; 
        $first = true; 
        foreach($this->properties as $key => $value) { 
            if (isset($value)) { 
                if (!$first) 
                    $url .= "&"; 
                $url .= $key."=".urlencode($value); 
                $first = false; 
            } 
        } 
        return $url;     
    } 

    /** 
     *    toHTML 
     */ 
    public function toHTML() { 
        return     '<img src="'. $this->getSrc() .'"' 
                .(!isset($this->size) ? "" : ' width="'.$this->size.'" height="'.$this->size.'"') 
                .$this->extra 
                .' />';     
    } 

    /** 
     *    toString 
     */ 
    public function __toString() { return $this->toHTML(); } 
} 

function dibujaGravatar ($correo){
    $url = "http://www.gravatar.com/avatar.php?"; 
    $url .= md5(strtolower($correo)); 
    return     '<img src="'. $url .'" />';     
}

?> 
