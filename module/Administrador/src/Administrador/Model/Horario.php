<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Horario
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Horario extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('catalogo_horario_laboral', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getHorarios() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getHorarioId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_horario' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addHorario($data=array())
        {
           $this->insert($data);
        }

    public function updateHorario($id, $data=array())
    {
        
        $this->update($data, array('id_horario' => $id));
    }

    public function deleteHorario($id)
    {
        $this->delete(array('id_horario' => $id));
    }
    public function getHorarioPaginator() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('catalogo_horario_laboral' => $this->table));
//                ->join(array('l' => 'log_in'), 'alumno.rfc = l.id_rfc ', array('status'));
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        return $paginator;
        
    }
}
