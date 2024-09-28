<?php
class Calificacion {
    private $cal_id;
    private $cal_usu_id;
    private $cal_cue_id;
    private $cal_calificacion;

    public function __construct($cal_id, $cal_usu_id, $cal_cue_id, $cal_calificacion) {
        $this->cal_id = $cal_id;
        $this->cal_usu_id = $cal_usu_id;
        $this->cal_cue_id = $cal_cue_id;
        $this->cal_calificacion = $cal_calificacion;
    }

    public function getCalId() {
        return $this->cal_id;
    }

    public function setCalId($cal_id) {
        $this->cal_id = $cal_id;
    }

    public function getCalUsuId() {
        return $this->cal_usu_id;
    }

    public function setCalUsuId($cal_usu_id) {
        $this->cal_usu_id = $cal_usu_id;
    }

    public function getCalCueId() {
        return $this->cal_cue_id;
    }

    public function setCalCueId($cal_cue_id) {
        $this->cal_cue_id = $cal_cue_id;
    }

    public function getCalCalificacion() {
        return $this->cal_calificacion;
    }

    public function setCalCalificacion($cal_calificacion) {
        $this->cal_calificacion = $cal_calificacion;
    }
}
