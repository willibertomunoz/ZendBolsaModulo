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
use Administrador\Model\Estado;

class AlumnoDireccionForm {

    private $municipio, $colonia, $calle, $cp, $estado, $action="direccion", $adapter;

    public function __construct(Alumno $alumno, $adapter) {
        $direccion = $alumno->getAtributoTabla("direccion");
        $this->municipio = $direccion["delegacion_municipio"];
        $this->colonia = $direccion["colonia"];
        $this->calle = $direccion["calle_numero"];
        $this->cp = $direccion["codigo_postal"];
        $this->estado = $direccion["id_estado"];
        $this->adapter = $adapter;
    }

    public function getFormulario() {
        $formulario = '
<form method="post"  role="form" id="direccionform">        
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Estado</span>
            <select name="id_estado" class="form-control" required>
                        ' . $this->getEstados() . '
            </select>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Municipio</span>
            <input type="text" name="delegacion_municipio" class="form-control" value="' . $this->municipio . '" required>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Colonia</span>
            <input type="text" name="colonia" class="form-control" value="' . $this->colonia . '" required>                
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Calle y numero</span>
            <input type="text" name="calle_numero" class="form-control" value="' . $this->calle . '" required>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Codigo Postal</span>
            <input type="number" name="codigo_postal" class="form-control" value="' . $this->cp . '" required>                
        </div>
    </div></br>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

    function getEstados() {
        $select = "";
        $estados = new Estado($this->adapter);
        foreach ($estados->getEstados() as $e) {
            if ($this->estado == $e['id_estado']) {
                $select = $select . "<option value='" . $e['id_estado'] . "' selected>" . $e['estado'] . "</option>";
            } else {
                $select = $select . "<option value='" . $e['id_estado'] . "'>" . $e['estado'] . "</option>";
            }
        }
        return $select;
    }

}
