<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author Guillermo
 */

namespace Alumno\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class AlumnoDatosPersonales extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('alumno_datos_personales', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getAlumnos() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getAlumnoCuenta($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_cuenta' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function getAlumnoByrfc($rfc)
     {
        $rowset = $this->select(array('rfc' => $rfc));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $rfc");
        }
        return $row;
     }
     public function addAlumno($data=array())
        {
           $this->insert($data);
        }

    public function updateAlumno($id, $data=array())
    {
        
        $this->update($data, array('id_cuenta' => $id));
    }

    public function deleteAlumno($id)
    {
        $this->delete(array('id_cuenta' => $id));
    }
    public function getAlumnoPaginator() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('alumno' => $this->table))
                ->order("apellido_paterno");
//                ->join(array('l' => 'log_in'), 'alumno.rfc = l.id_rfc ', array('status'));
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        return $paginator;
        
    }
}
