<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Idioma
 *
 * @author Guillermo
 */

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Idioma extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('catalogo_idiomas', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getIdiomas() {
        $datos = $this->select();
        return $datos->toArray();
    }
    public function getIdiomaId($id)
     {
        $id  = (int) $id;
        $rowset = $this->select(array('id_idioma' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
     }
     public function addIdioma($data=array())
        {
           $this->insert($data);
        }

    public function updateIdioma($id, $data=array())
    {
        
        $this->update($data, array('id_idioma' => $id));
    }

    public function deleteIdioma($id)
    {
        $this->delete(array('id_idioma' => $id));
    }
}
