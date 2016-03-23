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

class DatosPersonalesForm {

    public $va = "2", $sexoF, $sexoM, $estadoCivilSoltero, $estadoCivilCasado,
            $celular, $correoP, $correoA, $facebook, $twitter, $telefono, $action = "datospersonales",
            $perfilPublico , $perfilPrivado;

    public function __construct(Alumno $alumno) {
        $datos = $alumno->getAtributoTabla("DatosPersonales");
        if ($datos["sexo"] == "M") {
            $this->sexoM = "selected";
        } else {
            $this->sexoF = "selected";
        }
        if ($datos["estado_civil"] == "Soltero") {
            $this->estadoCivilSoltero = "selected";
        } else {
            $this->estadoCivilCasado = "selected";
        }
        if ($datos["tipo_perfil"] == "1") {
            $this->perfilPublico = "selected";
        } else {
            $this->perfilPrivado = "selected";
        }
        $this->telefono=$datos["telefono"];
        $this->celular=$datos["celular"];
        $this->correoP=$datos["email_principal"];
        $this->correoA=$datos["email_alternativo"];
        $this->facebook=$datos["facebook"];
        $this->twitter=$datos["twitter"];
    }

    public function getFormulario() {
        $formulario = ' 
<form method="post"  role="form" id="datospersonales" name="direccionf" enctype="multipart/form-data">        
    <div class="col-md-6"> 
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Sexo</span>
            <select name="sexo" class="form-control" required>
                <option value="F"' . $this->sexoF . '>Femenino</option>
                <option value="M"' . $this->sexoM . '>Masculino</option>
            </select>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Estado Civil</span>
            <select name="estado_civil" class="form-control">
                <option value="Soltero"' . $this->estadoCivilSoltero . '>Soltero</option>
                <option value="Casado"' . $this->estadoCivilCasado . '>Casado</option>
            </select>                </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="basic-addon1">Telefono</span>
            <input type="tel" name="telefono"  data-format="dd dddddddd" class="form-control input-medium bfh-phone"" required value="' . $this->telefono . '" required>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Celular</span>
            <input type="tel" name="celular" data-format="dd dddddddd" class="form-control input-medium bfh-phone" value="' . $this->celular . '">                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Correo Principal</span>
            <input type="email" name="email_principal" class="form-control" id="exampleInputEmail3" required value="' . $this->correoP . '">                
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Correo Alternativo</span>
            <input type="email" name="email_alternativo" class="form-control" value="' . $this->correoA . '" >                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Facebook</span>
            <input type="text" name="facebook" class="form-control" value="' . $this->facebook . '" >                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Twitter @:</span>
            <input type="text" name="twitter" class="form-control" value="' . $this->twitter . '" >                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Perfil</span>
            <select name="tipo_perfil" class="form-control">
                <option value="1" ' . $this->perfilPublico . '>publico</option>
                <option value="0" ' . $this->perfilPrivado . '>privado</option>
            </select>                
        </div>
        <div class=" form-group"><label>Foto</label>
            <input type="file" name="imagen" id="photo" accept="image/jpg" required>                
        </div>
    </div>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

}
