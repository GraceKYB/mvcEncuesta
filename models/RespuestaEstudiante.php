<?php
class RespuestaEstudiante {
    private $res_est_id;
    private $res_est_usu_id;
    private $res_est_cue_id;
    private $res_est_pre_id;
    private $res_est_res_id;

    public function __construct($res_est_id, $res_est_usu_id, $res_est_cue_id, $res_est_pre_id, $res_est_res_id) {
        $this->res_est_id = $res_est_id;
        $this->res_est_usu_id = $res_est_usu_id;
        $this->res_est_cue_id = $res_est_cue_id;
        $this->res_est_pre_id = $res_est_pre_id;
        $this->res_est_res_id = $res_est_res_id;
    }

    public function getResEstId() {
        return $this->res_est_id;
    }

    public function setResEstId($res_est_id) {
        $this->res_est_id = $res_est_id;
    }

    public function getResEstUsuId() {
        return $this->res_est_usu_id;
    }

    public function setResEstUsuId($res_est_usu_id) {
        $this->res_est_usu_id = $res_est_usu_id;
    }

    public function getResEstCueId() {
        return $this->res_est_cue_id;
    }

    public function setResEstCueId($res_est_cue_id) {
        $this->res_est_cue_id = $res_est_cue_id;
    }

    public function getResEstPreId() {
        return $this->res_est_pre_id;
    }

    public function setResEstPreId($res_est_pre_id) {
        $this->res_est_pre_id = $res_est_pre_id;
    }

    public function getResEstResId() {
        return $this->res_est_res_id;
    }

    public function setResEstResId($res_est_res_id) {
        $this->res_est_res_id = $res_est_res_id;
    }
}
