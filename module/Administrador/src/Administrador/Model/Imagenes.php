<?php

namespace Administrador\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class Imagenes extends TableGateway {

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct('imagenes_banner', $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function getImagenes() {
        $datos = $this->select();
        return $datos->toArray();
    }

    public function getImagenesId($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id_imagen' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("No hay registros asociados al valor $id");
        }
        return $row;
    }

    public function addImagenes($data = array()) {
        try {
            $this->insert($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function updateImagenes($id, $data = array()) {
        try {
            $this->update($data, array('id_imagen' => $id));
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function deleteImagenes($id) {
        $this->delete(array('id_imagen' => $id));
    }

    public function getImagenPaginator() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
                ->from(array('imagenes_banner' => $this->table));
//                ->join(array('l' => 'log_in'), 'alumno.rfc = l.id_rfc ', array('status'));
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        return $paginator;
    }

    public function lastImagen() {
        $rowset = $this->getSql()->select();
        $rowset->columns(array(
            'Nimagen' => new \Zend\Db\Sql\Expression('MAX(id_imagen)')
        ));

        $rowset = $this->selectWith($rowset);
        $row = $rowset->current();
        return $row;
    }

}
