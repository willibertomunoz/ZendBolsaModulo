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

use Alumno\Model\PreferenciasLaborales;
use Alumno\Model\Alumno;
use Zend\Db\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

class PreferenciaLaboralesForm {

    public $v_si, $v_no, $f_lab, $action="datoscomplementarios", $id_horario, $adapter, $sueldo;

    public function __construct(Alumno $alumno, $adapter) {
        $prefLab = $alumno->getAtributoTabla("PreferenciasLaborales");
        if ($prefLab["disponibilidad_viajar"] == 1) {
            $this->v_si = "selected";
        } else
            $this->v_no = "selected";
        $this->id_horario = $prefLab["id_horario"];
        $this->sueldo = $prefLab["sueldo_deseado"];
        $this->f_lab = $prefLab["fecha_para_laborar"];
        $this->adapter = $adapter;
    }

    public function getFormulario() {
        $formulario = ' 
<form method="post" id="preferencialab" >        
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Horario</span>
            <select name="id_horario" class="form-control" required>
                ' . $this->getHorario() . '
            </select>             
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Viajar</span>
            <select name="disponibilidad_viajar" class="form-control" required>
                <option value="0"' . $this->v_no . '>No</option>
                <option value="1"' . $this->v_si . '>Si</option>
            </select>                  
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Fecha de laborar</span>
            <input type="date" name="fecha_para_laborar" class="form-control" placeholder="dd/mm/aaaa" value="' . $this->f_lab . '" >   
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Sueldo</span>
            <select name="sueldo_deseado" class="form-control" required>
            ' . $this->getSueldo() . ' 
            </select>
        </div>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

    private function getSueldo() {
        $select = "";
        for ($i = 0; $i <= 10; $i++) {
            if ($this->sueldo > ($i - 1) * 5000 +1&& $this->sueldo < $i * 5000+1) {
                $select = $select . "<option value='" . ($i * 5000) . "' selected> $ " . number_format($i * 5000) . " - " . number_format(($i + 1) * 5000) . " Mensuales</option>";
            } else if ($i == 10) {
                $select = $select . "<option value='" . ($i * 5000) . "'> $ " . number_format($i * 5000) . " - o más Mensuales</option>";
            } else {
                $select = $select . "<option value='" . ($i * 5000) . "'> $ " . number_format($i * 5000) . " - " . number_format(($i + 1) * 5000) . " Mensuales</option>";
            }
        }
        return $select;
    }

    private function getHorario() {
        $select = "";
        $h = new \Administrador\Model\Horario($this->adapter);
        $result = $h->getHorarios();
        foreach ($result as $horario) {
            if ($this->id_horario == $horario["id_horario"]) {
                $select = $select . "<option value='" . $horario["id_horario"] . "' selected>" . $horario["horario"] . "</option>";
            } else {
                $select = $select . "<option value='" . $horario["id_horario"] . "'>" . $horario["horario"] . "</option>";
            }
        }
        return $select;
    }

}
