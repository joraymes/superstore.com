<?php 

class orderproduct {
    
    private $mysql;
    private $returnType;
    
    function __construct($type=''){
        $this->mysql = new mysqli('localhost','u_superstore','12345','superstore');
        $this->mysql->set_charset("utf8");
        $this->returnType= $type;
    }
    /*
     * Método get($id)
     */
    public function get($id){
        $sql="SELECT tbl_orders_products.* 
              FROM tbl_orders_products
              WHERE tbl_orders_products.id=$id
            ";
        $rsRows=$this->mysql->query($sql);
        $arrRow= $rsRows->fetch_assoc();
        switch($this->returnType){
            case 'json' :
                return json_encode($arrRow);
                break;
            case 'xml' :
                break;
            default :
                return $arrRow;
        }
    }
    /*
     * Método getAll()
     */
    public function getAll($start='',$page=''){
        $sql=" SELECT tbl_orders_products.*
               FROM tbl_orders_products
               WHERE 1
               ORDER BY tbl_orders_products.id ASC
            ";
        if($page!=''){
            $sql .= "LIMIT $start , $page ";
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
                break;
            default : 
                return $arrRows;
        }
    }
    /*
     * Método insert($data)
     */
    public function insert($data){
        foreach($data as $key=>$value){
            $fields[]=$key;
            $values[]="'".str_replace("'","''", $value)."'";
        }
        $sql="INSERT INTO tbl_orders_products (".implode(",",$fields).") VALUES (".implode(",",$values).") ";
        $this->mysql->query($sql);
        return $this->get($this->mysql->insert_id);
    }
    /*
     * Metodo update ($data)
     */
    public function update($id, $data){
        foreach($data as $key=>$value){
            $fields[]=$key."="."'".str_replace("'","''",$value)."'";
        }
        $sql="UPDATE tbl_orders_products SET ".implode(",",$fields)." WHERE id=$id ; ";
        $this->mysql->query($sql);
        return $this->get($id);
    }
    /*
     * Metodo delete ($id)
     */
    public function delete($id){
        $sql="DELETE FROM tbl_orders_products WHERE id=$id";
        $this->mysql->query($sql);
        switch($this->returnType){
            case 'json' :
                return json_encode(array("id"=>$id,"msg"=>"Deleted"));
                break;
            case 'xml': break;
            default :
                return $id;
        }
    }
    /*
     * Metodeo getProducts($id_orders)
     */
    public function getProducts($id_orders){
        $sql="SELECT tbl_orders_products.* , tbl_products.name, tbl_products.code, tbl_categories.category
              FROM tbl_orders_products
              LEFT JOIN tbl_products ON tbl_products.id=tbl_orders_products.id_products
              LEFT JOIN tbl_categories ON tbl_categories.id=tbl_products.id_categories
              WHERE tbl_orders_products.id_orders=$id_orders   ";
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
                break;
            default :
                return $arrRows;
        }
    }
    /*
     * Metodeo getOrders($id_products)
     */
    public function getOrders($id_products){
        $sql="SELECT 
              tbl_orders_products.* , 
              tbl_orders.code, tbl_orders.orderDate, tbl_orders.shipDate, tbl_orders.shipMode,
              tbl_products.code AS productCode , tbl_products.name, 
              tbl_customers.code AS customerCode, tbl_customers.name,tbl_customers.segment,
              tbl_cities.city, tbl_states.state, tbl_regions.region, tbl_countries.country
              FROM tbl_orders_products
              LEFT JOIN tbl_products ON tbl_products.id=tbl_orders_products.id_products
              LEFT JOIN tbl_orders ON tbl_orders.id=tbl_orders_products.id_orders
              LEFT JOIN tbl_customers ON tbl_customers.id=tbl_orders.id_customers
              LEFT JOIN tbl_cities ON tbl_cities.id=tbl_customers.id_cities
              LEFT JOIN tbl_states ON tbl_states.id = tbl_cities.id_states
              LEFT JOIN tbl_regions ON tbl_regions.id=tbl_cities.id_regions
              LEFT JOIN tbl_countries ON tbl_countries.id=tbl_states.id_countries
              WHERE id_products=$id_products";
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
                break;
            default :
                return $arrRows;
        }
    }

}









?>