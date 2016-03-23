<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class LogIn extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('log_in', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getLogins() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getLoginId($rfc, $digito) {
        $rfc =  $rfc;
        $digito = $digito;
        $rowset = $this->select(array('id_rfc' => $rfc,'digito_verificador' => $digito));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $rfc");
        }
        return $row;
    }

    public function addLogin($data = array()) {
        $this->insert($data);
    }

    public function updateLogin($rfc, $digito, $data = array()) {

        $this->update($data, array('id_rfc' => $rfc,'digito_verificador' => $digito));
    }

    public function deleteLogin($rfc, $digito) {
        $this->delete(array('id_rfc' => $rfc,'digito_verificador' => $digito));
    }

}
