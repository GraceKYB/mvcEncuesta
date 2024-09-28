<?php
class Respuesta {
    private $res_id;
    private $res_pre_id;
    private $res_texto;
    private $res_es_correcta;

    public function __construct($res_id, $res_pre_id, $res_texto, $res_es_correcta) {
        $this->res_id = $res_id;
        $this->res_pre_id = $res_pre_id;
        $this->res_texto = $res_texto;
        $this->res_es_correcta = $res_es_correcta;
    }

    public function getResId() {
        return $this->res_id;
    }

    public function setResId($res_id) {
        $this->res_id = $res_id;
    }

    public function getResPreId() {
        return $this->res_pre_id;
    }

    public function setResPreId($res_pre_id) {
        $this->res_pre_id = $res_pre_id;
    }

    public function getResTexto() {
        return $this->res_texto;
    }

    public function setResTexto($res_texto) {
        $this->res_texto = $res_texto;
    }

    public function getResEsCorrecta() {
        return $this->res_es_correcta;
    }

    public function setResEsCorrecta($res_es_correcta) {
        $this->res_es_correcta = $res_es_correcta;
    }
}
