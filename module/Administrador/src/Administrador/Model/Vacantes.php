<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vacante
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;

class Vacantes extends TableGateway {

    private $rfc, $digito, $vacante, $ayuda = array();

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('vacantes', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getvacantes() {
        $rowset = $this->select(
                function($select) {
            $select->join('empresas', 'vacantes.id_rfc = empresas.id_rfc '
                    . 'AND vacantes.digito_verificador = empresas.digito_verificador');
        });
        return $rowset->toArray();
    }

    public function getvacantesAlumno($idcuenta, $carrera) {
        $this->ayuda[0] = $idcuenta;
        $this->ayuda[1] = $carrera;
        $rowset = $this->select(
                function($select) {
            $select->join('empresas', 'vacantes.id_rfc = empresas.id_rfc '
                            . 'AND vacantes.digito_verificador = empresas.digito_verificador')
                    ->join('interesados', 'interesados.id_rfc=vacantes.id_rfc AND' .
                            ' interesados.num_vacante=vacantes.num_vacante and interesados.digito_verificador=vacantes.digito_verificador '
                            , array(), 'left')
                    ->where(array('interesados.id_cuenta' => $this->ayuda[0],
                        'vacantes.carrera_principal' => $this->ayuda[1], 'vacantes.status' => 1));
            $select->where->between("vacantes.fecha_hora_actualizacion", new \Zend\Db\Sql\Expression("NOW() - INTERVAL 3 MONTH"), new \Zend\Db\Sql\Expression("NOW()"));
        });
        return $rowset->toArray();
    }

    public function getvacanteId($id) {
        $id = (int) $id;
        $rowset = $this->select(array('carrera_principal' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
    }

    public function getvacanteNumVacante($rfc, $digito, $vacante) {
        $this->rfc = $rfc;
        $this->digito = $digito;
        $this->vacante = $vacante;
        $rowset = $this->select(
                function($select) {
            $select->where(array('vacantes.id_rfc' => $this->rfc, 'vacantes.digito_verificador' => $this->digito
                , 'vacantes.num_vacante' => $this->vacante));
            $select->join('empresas', 'vacantes.id_rfc = empresas.id_rfc '
                    . 'AND vacantes.digito_verificador = empresas.digito_verificador');
        });
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
    }

    public function getvacantesId($id, $cuenta) {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('vacantes' => $this->table))
                ->join(array('e' => 'empresas'), 'vacantes.id_rfc = e.id_rfc '
                        . 'AND vacantes.digito_verificador = e.digito_verificador', array('nombre_comercial'))
                ->join('interesados', 'interesados.id_rfc=vacantes.id_rfc AND' .
                        ' interesados.num_vacante=vacantes.num_vacante and interesados.digito_verificador=vacantes.digito_verificador '
                        , array(), 'left')
                ->where(array('vacantes.carrera_principal' => $id, 'vacantes.status' => 1));
        $select->where->isNull('interesados.id_cuenta')->
                between("vacantes.fecha_hora_actualizacion", new \Zend\Db\Sql\Expression("NOW() - INTERVAL 3 MONTH"),
                new \Zend\Db\Sql\Expression("NOW()"));
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

    public function getvacantesIdwhere($where) {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('vacantes' => $this->table))
                ->join(array('e' => 'empresas'), 'vacantes.id_rfc = e.id_rfc '
                        . 'AND vacantes.digito_verificador = e.digito_verificador', array('nombre_comercial'))
                ->where($where);
        $adapter = new DbSelect($select, $sql);
        $paginator = new Paginator($adapter);
        return $paginator;
    }

    public function addvacante($data = array()) {
        $this->insert($data);
    }

    public function updatevacante($rfc, $digito, $num, $data = array()) {

        $this->update($data, array('id_rfc' => $rfc, 'digito_verificador' => $digito, 'num_vacante' => $num));
    }

    public function deletevacante($id) {
        $this->delete(array('carrera_principal' => $id));
    }

}
