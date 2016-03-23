<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SitacionAcademica
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class SituacionAcademica extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('catalogo_situacion_academica', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getSitacionAcademicas() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getSitacionAcademicaId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_estado' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addSitacionAcademica($data=array())
        {
           $this->insert($data);
        }

    public function updateSitacionAcademica($id, $data=array())
    {
        
        $this->update($data, array('id_estado' => $id));
    }

    public function deleteSitacionAcademica($id)
    {
        $this->delete(array('id_estado' => $id));
    }
}
