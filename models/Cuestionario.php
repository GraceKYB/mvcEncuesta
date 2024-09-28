<?php

class Cuestionario {
    private $cue_id;
    private $cue_titulo;
    private $cue_descripcion;
    private $cue_profesor_id;
    private ?int $calificacion;

    public function __construct($cue_id, $cue_titulo, $cue_descripcion, $cue_profesor_id, $calificacion) {
        $this->cue_id = $cue_id;
        $this->cue_titulo = $cue_titulo;
        $this->cue_descripcion = $cue_descripcion;
        $this->cue_profesor_id = $cue_profesor_id;
        $this->calificacion = $calificacion;
    }

    public function getCalificacion(): ?int
    {
        return $this->calificacion;
    }
    public function getCueId() {
        return $this->cue_id;
    }

    public function setCueId($cue_id) {
        $this->cue_id = $cue_id;
    }

    public function getCueTitulo() {
        return $this->cue_titulo;
    }

    public function setCueTitulo($cue_titulo) {
        $this->cue_titulo = $cue_titulo;
    }

    public function getCueDescripcion() {
        return $this->cue_descripcion;
    }

    public function setCueDescripcion($cue_descripcion) {
        $this->cue_descripcion = $cue_descripcion;
    }

    public function getCueProfesorId() {
        return $this->cue_profesor_id;
    }

    public function setCueProfesorId($cue_profesor_id) {
        $this->cue_profesor_id = $cue_profesor_id;
    }
}
