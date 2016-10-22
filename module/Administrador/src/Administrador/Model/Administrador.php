<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Administrador
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Administrador extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('administradores', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getAdministradoress() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getAdministradorId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_rfc' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addAdministrador($data=array())
        {
           $this->insert($data);
        }

    public function updateAdministrador($id, $data=array())
    {
        
        $this->update($data, array('id_rfc' => $id));
    }

    public function deleteAdministrador($id)
    {
        $this->delete(array('id_rfc' => $id));
    }
    public function getAdministradorPaginator() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('administradores' => $this->table));
//                ->join(array('l' => 'log_in'), 'alumno.rfc = l.id_rfc ', array('status'));
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        return $paginator;
        
    }
}
