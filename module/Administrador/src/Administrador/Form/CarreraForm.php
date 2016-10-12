<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CarreraForm
 *
 * @author Guillermo
 */

namespace Administrador\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;

class CarreraForm extends Form {

    public function __construct($name = null) {
        parent::__construct($name);

        // $this->setInputFilter(new \Modulo\Form\AddUsuarioValidator());

        $this->setAttributes(array(
            //'action' => $this->url.'/modulo/recibirformulario',
            'action' => "",
            'method' => 'post'
        ));

        $this->add(array(
            'name' => 'id_carrera',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'carrera',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required'
            )
        ));
        $this->add(array(
            'name' => 'semestres_totales',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'required' => 'required'
            )
        ));
        $this->add(array(
            'type' => 'radio',
            'name' => 'status',
            'class' => '',
            'options' => array(
                'value_options' => array(
                    '1' => 'Activa',
                    '2' => 'Desactivada',
                ),
            ),
            'attributes' => array(
                'value' => '1' //set checked to '1'
            )
        ));
        $element = new Element\Radio('gender');
        $element->setValueOptions(array(
            'female' => array(
                'value' => '1',
            ),
            'male' => array(
                'value' => '2',
        )));
        $this->add($element);

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'title' => 'Entrar',
                'class' => 'btn btn-default'
            ),
        ));
    }

}
