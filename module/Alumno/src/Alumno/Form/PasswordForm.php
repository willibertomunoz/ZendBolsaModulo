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

class PasswordForm {

    public $action;

    public function __construct() {
        
    }

    public function getFormulario() {
        $formulario = ' 
<form id="passform" method="post"  class="form-horizontal" onchange="comprobar(this)" >       
                <div class="col-md-12">
                    <div class="input-group form-group">
                        <span class="input-group-addon">Contraseña Actual</span>
                        <input type="password" id="pass_actual" class="form-control" required>
                        
                    </div>
                    <div class="alert alert-danger" id="actual" role="alert" style="display: none;">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>Debe de tener minimo 6 caracteres</div>
                    <div class="alert alert-danger" id="actual_ver" role="alert" style="display: none;">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>No es tu contraseña actual</div>
                    <div class="input-group form-group">
                        <span class="input-group-addon">Nueva Contraseña</span>
                        <input type="password" name="password" id="pass" class="form-control" required >                  
                    </div>
                    <div class="alert alert-danger" id="new" role="alert" style="display: none;">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>Debe de tener minimo 6 caracteres</div>
                    <div class="input-group form-group">
                        <span class="input-group-addon">Confirmar Contraseña</span>
                        <input type="password" id="passc" class="form-control" required >   
                    </div>
                    <div class="alert alert-danger" id="new_re" role="alert" style="display: none;">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>Las contraseñas no son iguales</div>
                    
                    <div id="recatcha" class="col-md-12"></div>
                    <div class=" form-group" align=center>
                        <button type="submit" class="btn btn-default">Enviar</button>             
                    </div>
                </div>

            </form>';
        return $formulario;
    }

}
