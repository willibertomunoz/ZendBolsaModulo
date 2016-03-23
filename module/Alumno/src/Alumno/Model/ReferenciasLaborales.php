<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReferenciaLaboral
 *
 * @author Guillermo
 */

namespace Alumno\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class ReferenciasLaborales extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('referencias_laborales', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getReferenciaLaborals() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getReferenciaLaboralCuenta($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id_cuenta' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
    }

    public function addReferenciaLaboral($cuenta, $data = array()) {
        $data["id_cuenta"] = $cuenta;
        $this->insert($data);
    }

    public function updateReferenciaLaboral($id, $data = array()) {

        $this->update($data, array('id_cuenta' => $id));
    }

    public function deleteReferenciaLaboral($id,$empresa) {
        $this->delete(array('id_cuenta' => $id,'nombre_empresa' => $empresa));
    }

}
