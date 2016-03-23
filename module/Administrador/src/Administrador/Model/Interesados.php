<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Interesado
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Interesados extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('interesados', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getInteresados() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getInteresadoId($rfc, $digito, $vacante, $cuenta) {
        $rowset = $this->select(array('id_rfc' => $rfc, 'digito_verificador' => $digito,
            'id_cuenta' => $cuenta, 'num_vacante' => $vacante));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $rfc");
        }
        return $row;
    }

    public function addInteresado($data = array()) {
//        $this->insert($data);
        try {
            $data["fecha_hora"] = new \Zend\Db\Sql\Expression("NOW()");
            $this->insert($data);
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            return false;
        }
    }

    public function updateInteresado($rfc, $digito, $vacante, $cuenta, $data = array()) {

        $this->update($data, array('id_rfc' => $rfc, 'digito_verificador' => $digito,
            'id_cuenta' => $cuenta, 'num_vacante' => $vacante));
    }

    public function deleteInteresado($rfc, $digito, $vacante, $cuenta) {
        $this->delete(array('id_rfc' => $rfc, 'digito_verificador' => $digito,
            'id_cuenta' => $cuenta, 'num_vacante' => $vacante));
    }

}
