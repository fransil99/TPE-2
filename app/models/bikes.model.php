<?php

class BikesModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_motos;charset=utf8', 'root', '');
    }

    public function getAll($sort, $order)
    {
        $str_query = 'SELECT * FROM motos ORDER BY ';

        $columns = array(
            'nombre' => 'nombre',
            'imagen' => 'imagen',
            'descripcion' => 'descripcion',
            'cilindrada' => 'cilindrada',
            'precio' => 'precio',
            'id_marca_fk' => 'id_marca_fk'
        );


        if (isset($columns[$sort])) {
            $str_query .= $columns[$sort] ." ";
        } else {
            return null;
        }
        if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
            $str_query .= $order;
        } else {
            return null;
        }

        var_dump($str_query);
        var_dump($columns[$sort]);
        $query = $this->db->prepare($str_query); //LIMIT $starts_where, $size_pages
        $query->execute();
        $bikes = $query->fetchAll(PDO::FETCH_OBJ);
        return $bikes;
    }

    public function paginar($limit,){
            var_dump($limit);
            $str_query = 'SELECT * FROM motos LIMIT ';
            $str_query .= $limit;
            var_dump($str_query);
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

    // public function insert($nombre,$imagen,$descripcion,$cilindrada,$precio,$idFk){
    //     $pathImg = null;
    //     if($imagen){
    //     $pathImg = $this->uploadImage($imagen);
    //     $query = $this->db->prepare('INSERT INTO motos (nombre,imagen,descripcion,cilindrada,precio,id_marca_fk) VALUES (?,?,?,?,?,?)');
    //     $query->execute(array($nombre,$pathImg,$descripcion,$cilindrada,$precio,$idFk));
    // }else{
    //     $query = $this->db->prepare('INSERT INTO motos (nombre,descripcion,cilindrada,precio,id_marca_fk) VALUES (?,?,?,?,?)');
    //     $query->execute(array($nombre,$descripcion,$cilindrada,$precio,$idFk));
    //     }
    // }


    /**
     * Elimina una tarea dado su id.
     */
}
