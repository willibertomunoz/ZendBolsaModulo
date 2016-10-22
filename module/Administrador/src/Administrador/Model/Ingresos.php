<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ingresos
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql;
use Zend\Paginator\Adapter\DbSelect;

class Ingresos extends TableGateway {

    protected $adapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {

        return parent::__construct('ingresos', $adapter, $databaseSchema, $selectResultPrototype);
        
    }

    public function getIngresos() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function addIngresos($data = array()) {
        $this->insert($data);
    }

    public function updateIngresos($id, $data = array()) {

        $this->update($data, array('id_estado' => $id));
    }

    public function deleteIngresos($id) {
        $this->delete(array('id_estado' => $id));
    }

    public function getInformacionIndex() {
        $sql = 'select' .
                '"interesados" as titulo,' .
                'e.nombre_comercial as empresa,' .
                'CONCAT(ad.nombre," ",apellido_paterno," " ,apellido_materno)  as Alumno,' .
                'fecha_hora as fecha,' .
                'puesto,' .
                'case ifnull(contratado,0) ' .
                'when 0 then "Sin contratar" ' .
                'when 1 then "Contratado" end  as contratado ' .
                'from interesados as i ' .
                'inner join empresas as e on e.id_rfc=i.id_rfc ' .
                'inner join alumno_datos_personales as ad on ad.id_cuenta=i.id_cuenta ' .
                'INNER JOIN vacantes as v on v.num_vacante=i.num_vacante ' .
                'UNION ' .
                'select ' .
                '"ingresos",' .
                '"",' .
                'CONCAT(ad.nombre," ",apellido_paterno," " ,apellido_materno), ' .
                'log.fecha_hora_ingreso, ' .
                '"", ' .
                '""' .
                'from ingresos as log ' .
                'inner join alumno_datos_personales as ad on ad.rfc=log.id_rfc;';

        $statement = $this->adapter->createStatement($sql);
        $statement->prepare();
        $result = $statement->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($result);
        return $resultSet->toArray();
    }

}
