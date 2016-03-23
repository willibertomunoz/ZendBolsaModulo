<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author Guillermo
 */

namespace Alumno\Model;

use Alumno\Model\AlumnoDatosPersonales;
use Alumno\Model\AlumnoDireccion;
use Alumno\Model\AlumnoIdiomas;
use Alumno\Model\AlumnoDatosAcademicos;
use Alumno\Model\ReferenciasLaborales;
use Alumno\Model\PreferenciasLaborales;
use Administrador\Model\LogIn;
use Administrador\Model\Interesados;
use Zend\Db\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Alumno {

    static private $instancia = NULL;
    public $dbAdapter, $id_cuenta, $rfc, $alumno, $alumnoDir, $alumnoId, $alumnoDaAc, $aPostulaciones, $refernciaLab, $alumnoPreferenciaLab;
    private $alumnoDatosPersonales = array("nombre", "rfc", "apellido_paterno", "apellido_materno", "fecha_nacimiento"
        , "sexo", "estado_civil", "telefono", "celular", "email_principal", "email_alternativo", "facebook", "twitter", "tipo_perfil");
    private $alumnoDireccion = array("estado", "delegacion_municipio", "colonia", "calle_numero", "codigo_postal"),
            $alumnoIdiomas = array("idiomas", "nivel", "porcentaje_hablar", "porcentaje_leer", "porcentaje_esscuchar", "porcentaje_escribir"
                , "certificacion"),
            $alumnoDatosAcademicos = array("id_carrera", "carrera", "situacion", "semestre_actual", "porcentaje_creditos", "promedio_actual",
                "cursos_adicionales");

    function __construct($rfc, $db) {
        $this->rfc = $rfc;
        $this->dbAdapter = $db;
        $this->alumno = new AlumnoDatosPersonales($this->dbAdapter);
        $this->id_cuenta = $this->alumno->getAlumnoByrfc($this->rfc)["id_cuenta"];
        $this->alumnoDir = new AlumnoDireccion($this->dbAdapter);
        $this->alumnoId = new AlumnoIdiomas($this->dbAdapter);
        $this->alumnoDaAc = new AlumnoDatosAcademicos($this->dbAdapter);
        $this->refernciaLab = new ReferenciasLaborales($this->dbAdapter);
        $this->alumnoPreferenciaLab = new PreferenciasLaborales($this->dbAdapter);
    }

    public static function getInstance($rfc, $dbAdapter) {
        if (!self::$instancia instanceof self) {
            self::$instancia = new Alumno($rfc, $dbAdapter);
        }
        return self::$instancia;
    }

    public function getAtributoTabla($nomTabla) {
        switch ($nomTabla) {
            case 'DatosPersonales':
                return $this->alumno->getAlumnoCuenta($this->id_cuenta);
                break;
            case 'direccion':
                return $this->alumnoDir->getAlumnoCuenta($this->id_cuenta);
                break;
            case 'idiomas':
                return $this->alumnoId->getAlumnoCuenta($this->id_cuenta);
                break;
            case 'DatosAcademicos':
                return $this->alumnoDaAc->getAlumnoCuenta($this->id_cuenta);
                break;
            case 'PreferenciasLaborales':
                return $this->alumnoPreferenciaLab->getPreferenciasLaboralesId($this->id_cuenta);
                break;
            case 'Log_In':
                $l = new LogIn($this->dbAdapter);
                return $l->getLoginId($this->getAtributoTabla("DatosPersonales")["rfc"], "");
                break;
        }
    }

    public function getAtributo($nomAtributo) {
        for ($i = 0; $i < sizeof($this->alumnoDatosPersonales); $i++) {
            switch ($nomAtributo) {
                case $this->alumnoDatosPersonales[$i];
                    return $this->alumno->getAlumnoCuenta($this->id_cuenta)[$nomAtributo];
                    break;
            }
        }
        for ($i = 0; $i < sizeof($this->alumnoDireccion); $i++) {
            switch ($nomAtributo) {
                case $this->alumnoDireccion[$i];
                    return $this->alumnoDir->getAlumnoCuenta($this->id_cuenta)[$nomAtributo];
                    break;
            }
        }
        for ($i = 0; $i < sizeof($this->alumnoIdiomas); $i++) {
            switch ($nomAtributo) {
                case $this->alumnoIdiomas[$i];
                    return $this->alumnoId->getAlumnoCuenta($this->id_cuenta)[$nomAtributo];
                    break;
            }
        }
        for ($i = 0; $i < sizeof($this->alumnoDatosAcademicos); $i++) {
            switch ($nomAtributo) {
                case $this->alumnoDatosAcademicos[$i];
                    return $this->alumnoDaAc->getAlumnoCuenta($this->id_cuenta)[$nomAtributo];
                    break;
            }
        }
    }

    public function getPostulaciones() {
        $sql = new Sql\Sql($this->dbAdapter);
        $select = $sql->select()
                ->from(array("i" => 'interesados'))
                ->join(array('v' => 'vacantes'), 'i.id_rfc = v.id_rfc AND '
                        . 'i.digito_verificador = v.digito_verificador AND '
                        . 'i.num_vacante = v.num_vacante', array('puesto', 'vacantes_disponibles', 'sueldo'))
                ->join(array('e' => 'empresas'), 'v.id_rfc = e.id_rfc '
                        . 'AND i.digito_verificador = e.digito_verificador', array('nombre_comercial'))
                ->where(array('id_cuenta' => $this->id_cuenta));
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

    public function getReferenciasLaborales() {
        $sql = new Sql\Sql($this->dbAdapter);
        $select = $sql->select()
                ->from("referencias_Laborales")
                ->where(array('id_cuenta' => $this->id_cuenta));
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

    public function getIdiomas() {
        $sql = new Sql\Sql($this->dbAdapter);
        $select = $sql->select()
                ->from(array("i" => 'alumno_idiomas'))
                ->join(array('c' => 'catalogo_idiomas'), 'c.id_idioma = i.id_idioma', array('idioma'))
                ->where(array('id_cuenta' => $this->id_cuenta));
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

    public function updateDatosTabla($datos, $nomTabla) {
        switch ($nomTabla) {
            case 'DatosPersonales':
                $this->alumno->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'direccion':
                $this->alumnoDir->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'idiomas':
                return $this->alumnoId->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'DatosAcademicos':
                $this->alumnoDaAc->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'ReferenciaLaboral':
                $this->refernciaLab->updateReferenciaLaboral($this->id_cuenta, $datos);
                break;
            case 'PreferenciaLaboral':
                $this->alumnoPreferenciaLab->updatePreferenciasLaborales($this->id_cuenta, $datos);
                break;
            case 'Log_In':
                $l = new LogIn($this->dbAdapter);
                unset($datos["g-recaptcha-response"]);
                $l->updateLogin($this->getAtributoTabla("DatosPersonales")["rfc"], "", $datos);
                break;
            case 'foto':
                $l = new Alumno\AlumnoFoto($this->dbAdapter);
                $l->updateAlumno($this->id_cuenta, $datos);
                break;
        }
    }

    public function insertDatosTabla($datos, $nomTabla) {
        switch ($nomTabla) {
            case 'DatosPersonales':
                $this->alumno->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'direccion':
                $this->alumnoDir->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'idiomas':
                echo "s";
                return $this->alumnoId->addAlumno($this->id_cuenta, $datos);
                break;
            case 'DatosAcademicos':
                $this->alumnoDaAc->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'ReferenciaLaboral':
                $this->refernciaLab->addReferenciaLaboral($this->id_cuenta, $datos);
                break;
            case 'PreferenciasLaborales':
                $this->refernciaLab->addReferenciaLaboral($this->id_cuenta, $datos);
                break;
            case 'interesados':
//                $datos['id_rfc'] = $this->getAtributoTabla("DatosPersonales")["rfc"];
                $datos["id_cuenta"] = $this->id_cuenta;
                $l = new Interesados($this->dbAdapter);
                $l->addInteresado($datos);
                echo "ss";
                break;
        }
    }

    public function deleteDatosTabla($datos, $nomTabla) {
        switch ($nomTabla) {
            case 'DatosPersonales':
                $this->alumno->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'direccion':
                $this->alumnoDir->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'idiomas':
                echo "sss";
                $this->alumnoId->deleteAlumno($this->id_cuenta, $datos["id_idioma"]);
                break;
            case 'DatosAcademicos':
                $this->alumnoDaAc->updateAlumno($this->id_cuenta, $datos);
                break;
            case 'ReferenciaLaboral':
                $this->refernciaLab->deleteReferenciaLaboral($this->id_cuenta, $datos["nombre_empresa"]);
                break;
            case 'PreferenciasLaborales':
                $this->refernciaLab->addReferenciaLaboral($this->id_cuenta, $datos);
                break;
            case 'interesados':
//                $datos['id_rfc'] = $this->getAtributoTabla("DatosPersonales")["rfc"];
                $datos["id_cuenta"] = $this->id_cuenta;
                $l = new Interesados($this->dbAdapter);
                $l->addInteresado($datos);
                break;
        }
    }

}
