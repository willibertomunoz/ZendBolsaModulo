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

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Administrador\Model\Carrera;

class AlumnoDatosAcademicos extends TableGateway {

    private $carrera;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        $this->carrera = new Carrera($adapter);
        return parent::__construct('datos_academicos', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getAlumnos() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getAlumnoCuenta($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id_cuenta' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        $row["carrera"] = $this->carrera->getCarreraId($row["id_carrera"])["carrera"];
        return $row;
    }

    public function addAlumno($data = array()) {
        $this->insert($data);
    }

    public function updateAlumno($id, $data = array()) {

        $this->update($data, array('id_cuenta' => $id));
    }

    public function deleteAlumno($id) {
        $this->delete(array('id_cuenta' => $id));
    }

}
