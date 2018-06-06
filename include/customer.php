<?php 

class customer {
    
    private $mysql;
    private $returnType;
    
    private $inicio;
    private $pagina;
    private $registros=15;
    
    private $total_registros;
    private $total_paginas;
    
    // Constructor
    function __construct($type='') {
        $this->mysql        =  new mysqli('localhost','u_superstore','12345','superstore');
        $this->mysql->set_charset("utf8");
        $this->returnType   = $type;
    }
    
    
    /*
     * 
     */
    public function get($id){
        $sql="SELECT tbl_customers.*, tbl_cities.city, tbl_regions.region, tbl_states.state, tbl_countries.country
            FROM tbl_customers
            LEFT JOIN tbl_cities    ON tbl_cities.id    = tbl_customers.id_cities
            LEFT JOIN tbl_regions   ON tbl_regions.id   = tbl_cities.id_regions
            LEFT JOIN tbl_states    ON tbl_states.id    = tbl_cities.id_states
            LEFT JOIN tbl_countries ON tbl_countries.id = tbl_states.id_countries
            WHERE tbl_customers.id=$id    ";
            $rsRows=$this->mysql->query($sql);
            $arrRow=$rsRows->fetch_assoc();
            switch($this->returnType){
                case 'json' : 
                    return json_encode($arrRow);
                    break;
                case 'xml': 
                    $xml= new DOMDocument();
                    $xml->encoding ='UTF-8';
                    $rootTag=$xml->createElement('customer');
                    foreach($arrRow as $key=>$value){
                        $tag= $xml->createElement($key,$value);
                        $rootTag->appendChild($tag);
                    }
                    $xml->appendChild($rootTag);
                    return $xml->saveXML();
                    break;
                default : 
                    return $arrRow;
            }
            
    }
    /*
     * 
     */
    public function getAll($start='',$page=''){
        $sql="SELECT tbl_customers.*, tbl_cities.city, tbl_regions.region, tbl_states.state, tbl_countries.country
            FROM tbl_customers
            LEFT JOIN tbl_cities    ON tbl_cities.id        = tbl_customers.id_cities
            LEFT JOIN tbl_regions   ON tbl_regions.id       = tbl_cities.id_regions
            LEFT JOIN tbl_states    ON tbl_states.id        = tbl_cities.id_states
            LEFT JOIN tbl_countries ON tbl_countries.id     = tbl_states.id_countries
            WHERE 1
            ORDER BY tbl_customers.id
        ";
        if($page!=''){
            $sql .= "LIMIT $start ,  $page"; 
        }
        $rsRows=$this->mysql->query($sql);
        $arrRows=array();
        while($arrRow=$rsRows->fetch_assoc()){
            $arrRows[]=$arrRow;
        }
        switch($this->returnType){
            case 'json' :
                return json_encode($arrRows);
                break;
            case 'xml':
                $xml= new DOMDocument();
                $xml->encoding ='UTF-8';
                $rootTag=$xml->createElement('customers');
                for($k=0; $k<count($arrRows);$k++){
                    $nodeTag=$xml->createElement('customer');
                    foreach(  $arrRows[$k]   as   $key  =>  $value){
                        $tag= $xml->createElement($key,$value);
                        $nodeTag->appendChild($tag);
                    }
                    $rootTag->appendChild($nodeTag);
                }
                $xml->appendChild($rootTag);
                return $xml->saveXML();
                break;
            default :
                return $arrRows;
        }
    }
    
    /*
     * 
     */
    public function insert($data){
        foreach($data as $key=>$value){
            $fields[]=$key;
            $values[]="'".str_replace("'" , "''", $value)."'";
        }
        $sql="INSERT INTO tbl_customers  (".implode(",",$fields).") VALUES (".implode(",",$values)."); ";
        $this->mysql->query($sql);
        
        return $this->get($this->mysql->insert_id);
    }
    /*
     * 
     */
    public function update($id , $data){
        
        foreach($data as $key=>$value){
            $fields[]=$key ."="."'".str_replace("'" , "''", $value)."'";
        }
        $sql="UPDATE tbl_customers SET ".implode(",", $fields)." WHERE id=$id ;";
        
        $this->mysql->query($sql);
        return $this->get($id);
    }
    /*
     * 
     */
    public function delete($id){
        
        $sql="DELETE FROM tbl_customers  WHERE id=$id ;";
        switch($this->returnType){
            case 'json' :
                return json_encode(array("id"=>$id,"msg"=>"Deleted"));
                break;
            case 'xml': break;
                $xml= new DOMDocument();
                $xml->encoding ='UTF-8';
                $rootTag=$xml->createElement('customer');
                $tag= $xml->createElement("id",$id);
                $rootTag->appendChild($tag);
                $tag= $xml->createElement("msg","Deleted");
                $rootTag->appendChild($tag);
                $xml->appendChild($rootTag);
                return $xml->saveXML();
                break;
            default :
                return $id;
        }
        
    }
    /*
     * 
     */
    public function pagination($pag,$reg){
        $this->registros=$reg;
        if (!$pag) {
            $this->inicio = 0;
            $this->pagina = 1;
        } else {
            $this->pagina=$pag;
            $this->inicio = ($this->pagina - 1) * $this->registros;
        }
        
        /** Capturem el número total de registres*/
        $this->total_registros =   count($this->getAll()) ;
        /** Amb ceil arrodonim el resultat total de las paginess 4.53213 = 5 */
        $this->total_paginas = ceil($this->total_registros / $this->registros);
        
        return $this->getAll($this->inicio,$this->registros);
        
    }
    /*
     * 
     */
    public function getLinks(){
        if ($this->total_registros) {
            /*
             * Primero
             */
            if (($this->pagina - 1) > 0) {
                echo "<label><a href=\"./\">Primero</a></label>";
            } else {
                echo "<label>Primero</label>";
            }
            
            /**
             * Acá activamos o desactivamos la opción "< Anterior", si estamos
             * en la pagina 1 nos dará como resultado 0 por ende NO
             * activaremos el primer if y pasaremos al else en donde
             * se desactiva la opción anterior. Pero si el resultado es mayor
             * a 0 se activara el href del link para poder retroceder.
             */
            if (($this->pagina - 1) > 0) {
                echo "<label><a href=\"?pagina=".($this->pagina-1)."\">&lt; Anterior</a></label>";
            } else {
                echo "<label>&lt; Anterior</label>";
            }
            
            // Generamos el ciclo para mostrar la cantidad de paginas que tenemos.
            
            
            $start      = ( ( $this->pagina - 5 ) > 0 ) ? $this->pagina -5: 1;
            $end        = ( ( $this->pagina + 5 ) < $this->total_paginas ) ? $this->pagina + 5 : $this->total_paginas;
            for ($i = $start; $i <= $end; $i++) {
                
                if ($this->pagina == $i) {
                    echo "<label>". $this->pagina ."</label>";
                } else {
                    echo "<label><a href=\"?pagina=$i\">$i</a></label>";
                }
            }
            
            /**
             * Igual que la opción primera de "< Anterior", pero acá para la opción "Siguiente >",
             *  si estamos en la ultima pagina no podremos
             * utilizar esta opción.
             */
            if (($this->pagina + 1)<=$this->total_paginas) {
                echo "<label><a href=\"?pagina=".($this->pagina+1)."\">Siguiente &gt;</a></label>";
            } else {
                echo "<label>Siguiente &gt;</label>";
            }
            /*
             * Ultimo
             */
            if (($this->pagina + 1)<=$this->total_paginas) {
                echo "<label><a href=\"?pagina=".$this->total_paginas."\">Último</a></label>";
            } else {
                echo "<label>Último</label>";
            }
            
            echo "<span style=\"float:right\">Página:".$this->pagina." de ".$this->total_paginas."</span>";
            echo "<div style=\"clear:both;\"></div>";
        }
        
        
    }
}
?>