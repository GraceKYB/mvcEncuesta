<?php
class Perfil {
private $per_id;
private $per_nombre;

public function __construct($per_id, $per_nombre) {
$this->per_id = $per_id;
$this->per_nombre = $per_nombre;
}

public function getPerId() {
return $this->per_id;
}

public function setPerId($per_id) {
$this->per_id = $per_id;
}

public function getPerNombre() {
return $this->per_nombre;
}

public function setPerNombre($per_nombre) {
$this->per_nombre = $per_nombre;
}
}
