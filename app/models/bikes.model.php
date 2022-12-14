<?php

class BikesModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_motos;charset=utf8', 'root', '');
    }

    public function getAll($sort, $order, $limit, $offset)
    {

        $str_query = 'SELECT * FROM motos ORDER BY ';

        $columns = array(
            'nombre' => 'nombre',
            'imagen' => 'imagen',
            'descripcion' => 'descripcion',
            'cilindrada' => 'cilindrada',
            'precio' => 'precio',
            'marca' => 'id_marca_fk'
        );


        if (isset($columns[$sort])) {
            $str_query .= $columns[$sort] ." ";
        } else {
            return null;
        }
        if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
            $str_query .= $order ." " ;
        } else {
            return null;
        }

        $str_query .= 'LIMIT'." ". $limit ." " . 'OFFSET '." ". $offset;
        $query = $this->db->prepare($str_query); //LIMIT $starts_where, $size_pages
        $query->execute();
        $bikes = $query->fetchAll(PDO::FETCH_OBJ);
        return $bikes;
    }
        
    

    public function get($id)
    {
        $query = $this->db->prepare("SELECT * FROM motos WHERE id_moto = ?");
        $query->execute([$id]);
        $bike = $query->fetch(PDO::FETCH_OBJ);

        return $bike;
    }

    function delete($id)
    {
        $query = $this->db->prepare('DELETE FROM motos WHERE id_moto =?');
        $query->execute([$id]);
    }

    public function insert($title, $description, $cc, $price, $imagen, $idFk)
    {
        $query = $this->db->prepare("INSERT INTO motos (nombre, descripcion, cilindrada, precio,imagen, id_marca_fk) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$title, $description, $cc, $price, $imagen, $idFk]);

        return $this->db->lastInsertId();
    }
}
