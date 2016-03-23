<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Carrera
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Carrera extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('catalogo_carreras', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getCarreras() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getCarreraId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_carrera' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addCarrera($data=array())
        {
           $this->insert($data);
        }

    public function updateCarrera($id, $data=array())
    {
        
        $this->update($data, array('id_carrera' => $id));
    }

    public function deleteCarrera($id)
    {
        $this->delete(array('id_carrera' => $id));
    }
    public function getcarreraPaginator() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('carrera' => $this->table));
//                ->join(array('l' => 'log_in'), 'alumno.rfc = l.id_rfc ', array('status'));
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        return $paginator;
        
    }
}
