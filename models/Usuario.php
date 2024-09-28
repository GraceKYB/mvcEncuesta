<?php
class Usuario {
    private $usu_id;
    private $usu_nombre;
    private $usu_correo;
    private $usu_contrasena;
    private $usu_per_id;

    public function __construct($usu_id, $usu_nombre, $usu_correo, $usu_contrasena, $usu_per_id) {
        $this->usu_id = $usu_id;
        $this->usu_nombre = $usu_nombre;
        $this->usu_correo = $usu_correo;
        $this->usu_contrasena = $usu_contrasena;
        $this->usu_per_id = $usu_per_id;
    }

    public function getUsuId() {
        return $this->usu_id;
    }

    public function setUsuId($usu_id) {
        $this->usu_id = $usu_id;
    }

    public function getUsuNombre() {
        return $this->usu_nombre;
    }

    public function setUsuNombre($usu_nombre) {
        $this->usu_nombre = $usu_nombre;
    }

    public function getUsuCorreo() {
        return $this->usu_correo;
    }

    public function setUsuCorreo($usu_correo) {
        $this->usu_correo = $usu_correo;
    }

    public function getUsuContrasena() {
        return $this->usu_contrasena;
    }

    public function setUsuContrasena($usu_contrasena) {
        $this->usu_contrasena = $usu_contrasena;
    }

    public function getUsuPerId() {
        return $this->usu_per_id;
    }

    public function setUsuPerId($usu_per_id) {
        $this->usu_per_id = $usu_per_id;
    }
}
