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

class ReferenciaLaboralesForm {

    public $action="referenciaslaborales";

    public function __construct() {

    }

    public function getFormulario() {
        $formulario = ' 
<form method="post"  id="referencialab">        
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Empresa</span>
            <input type="text" name="nombre_empresa" class="form-control"  required>               
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Fecha de Inicio</span>
            <input type="date" name="fecha_inicio" class="form-control" required >                  
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Fecha de Salida</span>
            <input type="date" name="fecha_fin" class="form-control" required >   
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Puesto</span>
            <input type="text" name="puesto" class="form-control" required >   
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">sueldo</span>
            <input type="number" name="sueldo" class="form-control" required >   
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Jefe Directo</span>
            <input type="text" name="jefe_directo" class="form-control" required >   
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Telefono</span>
            <input type="tel" name="tel_jefe_directo" class="form-control" >   
        </div>
    </div>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

}
