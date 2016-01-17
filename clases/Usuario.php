<?php

/*
create table usuario (
  email varchar(80) primary key not null,
  clave varchar(40) not null,
  alias varchar(40) unique,
  fechaalta date not null,
  activo tinyint(1) not null default 0,
  administrador tinyint(1) not null default 0,
  personal tinyint(1) not null default 0
);
*/

class Usuario {
    
    private $email, $clave, $alias, $fechaalta, $activo, $administrador, $personal;
            
    function __construct($email = null, $clave = null, $alias = null, $fechaalta = null, $activo = 0, $administrador = 0, $personal = 0) {
        $this->email = $email;
        $this->clave = $clave;
        $this->alias = $alias;
        $this->fechaalta = $fechaalta;
        $this->activo = $activo;
        $this->administrador = $administrador;
        $this->personal = $personal;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function getFechaalta() {
        return $this->fechaalta;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getAdministrador() {
        return $this->administrador;
    }

    public function getPersonal() {
        return $this->personal;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function setFechaalta($fechaalta) {
        $this->fechaalta = $fechaalta;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

    public function setPersonal($personal) {
        $this->personal = $personal;
    }

    public function getJson() {
        $r = '{';
        foreach ($this as $indice => $valor) {
            $r .= '"' . $indice . '"' . ':' . '"' . $valor . '"' . ',' ;
        }
        $r = substr($r, 0, -1);
        $r .= '}';
        return $r;
    }
    
    function set($valores, $inicio=0) {
        $i = 0;
        foreach ($this as $indice => $valor) {
            $this->$indice = $valores[$i+$inicio];
            $i++;
        }
    }
    
     public function __toString() {
        $r = '';
        foreach ($this as $key => $valor){
            $r .= "$valor ";
        }
        return $r;
    }
    
    public function getArray($valores=true) {
        $array = array();
        foreach ($this as $key => $valor) {
            if($valores===true){
                $array[$key] = $valor;
            }else{
                $array[$key] = null;
            }
        }
        return $array;
    }
    
    function read() {
        foreach ($this as $key => $valor){
            $this->$key = Request::req($key);
        }
    }

}
