<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatosPersonalesForm
 *
 * @author Guillermo
 */

namespace Alumno\Form;

use Alumno\Model\Alumno;

class DatosAcademicosForm {

    public $carrera, $creditos, $promedio, $cursos, $action, $carreradisable, $nomcarrera, $semestre,$situacionAcademica;

    public function __construct(Alumno $alumno, $adapter) {
        $dAcademicos = $alumno->getAtributoTabla("DatosAcademicos");
        $this->creditos = $dAcademicos["porcentaje_creditos"];
        $this->promedio = $dAcademicos["promedio_actual"];
        $this->cursos = $dAcademicos["cursos_adicionales"];
        $this->semestre = $dAcademicos["semestre_actual"];
        $this->carrera = $dAcademicos["id_carrera"];
        $this->situacionAcademica = $dAcademicos["id_situacion"];
        $this->adapter = $adapter;
        $this->carreradisable="disabled";
    }

    public function getFormulario() {
        $formulario = ' 
<form method="post"  id="dacademicos" role="form">        
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Carrera</span>
            <select name="id_carrera" class="form-control" required ' . $this->carreradisable . '>
                ' . $this->getCarrera() . '
            </select>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Semestre</span>
            <select name="semestre_actual" class="form-control">
                ' . $this->getSemestre() . '
            </select>                </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Situación Academica</span>
            <select name="id_situacion" class="form-control" required >
                ' . $this->getsituacionAcademica() . '
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Creditos</span>
            <input type="number" name="porcentaje_creditos" class="form-control" value="' . $this->creditos . '" > 
            <span class="input-group-addon">%</span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Promedio</span>
            <input type="number" name="promedio_actual" class="form-control" value="' . $this->promedio . '" >                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Cursos</span>
            <textarea rows="5" cols="50" name="cursos_adicionales" class="form-control" >' . $this->cursos . '</textarea>                
        </div>
        
    </div>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

    public function getSemestre() {
        $select = "";
        $carrera = new \Administrador\Model\Carrera($this->adapter);
        $c = $carrera->getCarreraId($this->carrera);
        for ($i = 1; $i <= $c["semestres_totales"]; $i++) {
            if ($this->semestre == $i) {
                $select = $select . "<option value='" . $i . "' selected>" . $i . "</option>";
            } else {
                $select = $select . "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        return $select;
    }

    public function getsituacionAcademica() {
         $select = "";
        $SituacionA = new \Administrador\Model\SituacionAcademica($this->adapter);
        foreach ($SituacionA->getSitacionAcademicas() as $sa) {
            if ($this->situacionAcademica == $sa['id_situacion']) {
                $select = $select . "<option value='" . $sa['id_situacion'] . "' selected>" . $sa['situacion'] . "</option>";
            } else {
                $select = $select . "<option value='" . $sa['id_situacion'] . "'>" . $sa['situacion'] . "</option>";
            }
        }
        return $select;
    }

    public function getCarrera() {
        $select = "";
        $carrera = new \Administrador\Model\Carrera($this->adapter);
        foreach ($carrera->getCarreras() as $e) {
            if ($this->carrera == $e['id_carrera']) {
                $select = $select . "<option value='" . $e['id_carrera'] . "' selected>" . $e['carrera'] . "</option>";
            } else {
                $select = $select . "<option value='" . $e['id_carrera'] . "'>" . $e['carrera'] . "</option>";
            }
        }
        return $select;
    }

}
