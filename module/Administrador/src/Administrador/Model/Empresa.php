<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Empresa extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('empresas', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getEmpresas() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getEmpresaId($rfc, $digito) {
        $rowset = $this->select(array('id_rfc' => $rfc, 'digito_verificador' => $digito));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $rfc");
        }
        return $row;
    }

    public function addEmpresa($data = array()) {
        $this->insert($data);
    }

    public function updateEmpresa($rfc, $digito, $data = array()) {

        $this->update($data, array('id_rfc' => $rfc, 'digito_verificador' => $digito));
    }

    public function deleteEmpresa($rfc, $digito) {
        $this->delete(array('id_rfc' => $rfc, 'digito_verificador' => $digito));
    }
    public function getEmpresaWhere($where) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('empresa' => $this->table))
                ->where($where);
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

}
