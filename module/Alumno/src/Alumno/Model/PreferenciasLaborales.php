<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PreferenciasLaborale
 *
 * @author Guillermo
 */

namespace Alumno\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class PreferenciasLaborales extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('preferencias_laborales', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getPreferenciasLaborales() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getPreferenciasLaboralesId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_cuenta' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addPreferenciasLaborale($data=array())
        {
           $this->insert($data);
        }

    public function updatePreferenciasLaborales($id, $data=array())
    {
        
        $this->update($data, array('id_cuenta' => $id));
    }

    public function deletePreferenciasLaborale($id)
    {
        $this->delete(array('id_cuenta' => $id));
    }
}
