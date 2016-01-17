<?php

class ManageUsuario {
    
    private $bd = null;
    private $tabla = "usuario";
    
    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }
    
    function get($email) {
        //devuelve el objeto de la fila cuyo email coincide con el email que le estoy pasando;
        //devuelve el objeto entero;
        $parametros = array();
        $parametros["email"] = $email;
        $this->bd->select($this->tabla, "*", "email =:email", $parametros);
        $fila = $this->bd->getRow();
        $usuario = new Usuario();
        $usuario->set($fila);
        return $usuario;
    }
    
    function count($condicion="1=1", $parametros=array()){
        return $this->bd->count($this->tabla, $condicion, $parametros);
    }
            
    function delete($email) {
        //borrar por id
        $parametros = array();
        $parametros["email"] = $email;
        return $this->bd->delete($this->tabla, $parametros);
    }
    
//    function forzarDelete($email) {
//        $parametros = array();
//        $parametros['CountryCode'] = $Code;
//        $gestor = new ManageCity($this->bd);
//        $gestor->deleteCities($parametros);
//        $this->bd->delete("countrylanguage", $parametros);
//        $parametros = array();
//        $parametros["Code"] = $Code;
//        return $this->delete($this->tabla, $parametros);
//    }
    
    function deleteUsuarios($parametros){
        return $this->bd->delete($this->tabla, $parametros);
    }
    
    function erase(Usuario $usuario) {
        //borrar por nombre
        //dice ele numero de filas borratas
        return $this->delete($usuario->getEmail());
    }
    
    function set(Usuario $usuario, $pkEmail) {
        //update de todos los campos 
        //pasamos el codigo que tenia y como en este si se puede cambiar el codigo, cambiamos todos los campos
        //dice el numero de filas modificades
        $parametros = $usuario->getArray();
        $parametrosWhere = array();
        $parametrosWhere["email"] = $pkEmail;
        $this->bd->update($this->tabla, $parametros, $parametrosWhere);
    }
    
    function insert(Usuario $usuario) {
        //se le pasa un objeto City y lo inserta en la tabla
        //dice el numero de filas insertadas;
        $parametrosSet = array();
        $parametrosSet["email"]=$usuario->getEmail();
        $parametrosSet["clave"]=$usuario->getClave();
        $parametrosSet["alias"]=$usuario->getAlias();
        $parametrosSet["fechaalta"]=$usuario->getFechaalta();
        $parametrosSet["activo"]=$usuario->getActivo();
        $parametrosSet["administrador"]=$usuario->getAdministrador();
        $parametrosSet["personal"]=$usuario->getPersonal();
        return $this->bd->insert($this->tabla, $parametrosSet);
    }
    
    function getList($pagina=1, $orden="", $nrpp=Constants::NRPP, $condicion ="1=1", $parametros=array()) {
        $ordenPredeterminado = "$orden, fechaalta, email";
        if(trim($orden)==="" || trim($orden)===null){
            $ordenPredeterminado = "fechaalta, email";
        }
        $registroInicial = ($pagina - 1) * $nrpp;
        $this->bd->select($this->tabla, "*", $condicion, $parametros, $ordenPredeterminado,
                "$registroInicial, $nrpp");
        $r = array();
        while ($fila = $this->bd->getRow()){
            $usuario = new Usuario();
            $usuario->set($fila);
            $r[] = $usuario;
        }
        return $r;
    }
    
    function getValuesSelect() {
        $this->bd->query($this->tabla, "ID, Name", array(), "Name");
        $array = array();
        while ($fila = $this->bd->getRow()){
            $array[$fila[0]] = $fila[1];
        }
        return $array;
    }
    
}
