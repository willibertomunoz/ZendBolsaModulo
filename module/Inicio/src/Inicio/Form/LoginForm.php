<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginForm
 *
 * @author Guillermo
 */
namespace Inicio\Form;
 
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;
 
class LoginForm extends Form
{
    public function __construct($name = null)
     {
        parent::__construct($name);
         
      // $this->setInputFilter(new \Modulo\Form\AddUsuarioValidator());
         
       $this->setAttributes(array(
            //'action' => $this->url.'/modulo/recibirformulario',
            'action'=>"",
            'method' => 'post'
        ));
         
        $this->add(array(
            'name' => 'id_rfc',
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
         
         $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
          
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(     
                'type' => 'submit',
                'value' => 'Entrar',
                'title' => 'Entrar',
                'class' => 'btn btn-default'
            ),
        ));
  
     }
}