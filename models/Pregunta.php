<?php
class Pregunta {
    private $pre_id;
    private $pre_cue_id;
    private $pre_texto;

    public function __construct($pre_id, $pre_cue_id, $pre_texto) {
        $this->pre_id = $pre_id;
        $this->pre_cue_id = $pre_cue_id;
        $this->pre_texto = $pre_texto;
    }

    public function getPreId() {
        return $this->pre_id;
    }

    public function setPreId($pre_id) {
        $this->pre_id = $pre_id;
    }

    public function getPreCueId() {
        return $this->pre_cue_id;
    }

    public function setPreCueId($pre_cue_id) {
        $this->pre_cue_id = $pre_cue_id;
    }

    public function getPreTexto() {
        return $this->pre_texto;
    }

    public function setPreTexto($pre_texto) {
        $this->pre_texto = $pre_texto;
    }
}
