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

class IdiomasForm {

    private $action="idiomas", $basico, $intermedio, $avanzado, $hablado, $lectura, $escritura, $escuchado, $certificacion,$adapter;

    public function __construct( $adapter) {
        
        $this->adapter = $adapter;
    
    }

    public function getFormulario() {
        $formulario = ' 
<form method="post"  role="form" id ="idiomasForm">        
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Idioma</span>
            <select name="id_idioma" class="form-control" required>
                ' . $this->getIdioma() . '
            </select>                
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Nivel</span>
            <select name="nivel" class="form-control" required>
                <option value="Basico" ' . $this->basico . '>Basico</option>
                <option value="Intermedio" ' . $this->intermedio . '>Intermedio</option>
                <option value="Avanzado" ' . $this->avanzado . '>Avanzado</option>
            </select>                 
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Hablado</span>
            <input type="number" name="porcentaje_hablar" class="form-control" value="' . $this->hablado . '" required>  
            <span class="input-group-addon">%</span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Lectura</span>
            <input type="number" name="porcentaje_leer" class="form-control" value="' . $this->lectura . '" required>
            <span class="input-group-addon">%</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group form-group">
            <span class="input-group-addon">Escritura</span>
            <input type="number" name="porcentaje_escribir" class="form-control" value="' . $this->escritura . '" required> 
            <span class="input-group-addon">%</span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Escuchado</span>
            <input type="number" name="porcentaje_escuchar" class="form-control" value="' . $this->escuchado . '" required>
            <span class="input-group-addon">%</span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon">Certificaci&oacute;n</span>
            <input type="text" name="certificacion" class="form-control" value="' . $this->certificacion . '" >   
        </div>
    </div>
    <div class=" form-group" align=center>
        <button type="submit" class="btn btn-default">Enviar</button>             
    </div>
</form>';
        return $formulario;
    }

    private function getIdioma() {
        $select = "";
        $Idioma = new \Administrador\Model\Idioma($this->adapter);
        foreach ($Idioma->getIdiomas() as $idioma) {
            if ($this->certificacion == $idioma['id_idioma']) {
                $select = $select . "<option value='" . $idioma['id_estado'] . "' selected>" . $idioma['estado'] . "</option>";
            } else {
                $select = $select . "<option value='" . $idioma['id_idioma'] . "'>" . $idioma['idioma'] . "</option>";
            }
        }
        return $select;
    }

}
