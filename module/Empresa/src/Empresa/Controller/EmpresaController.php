<?php

namespace Empresa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EmpresaController extends AbstractActionController {
private $rfc='0123456789910',$digito='0122';
    public function indexAction() {
        $this->layout = $this->layout();
        $this->layout->setTemplate('layout/Empresa');
        $view = new ViewModel();
        if ($this->getRequest()->isPost())
            $view->setTerminal(true);
        return $view;
    }

    public function perfilAction() {
        $this->layout = $this->layout();
        $this->layout->setTemplate('layout/Empresa');
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $empresa = new \Administrador\Model\Empresa($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $empresa->updateEmpresa($post["id_rfc"], $post["digito_verificador"], $post);
            echo "<script>parent.fnExitoso();</script>";
        }
        $empresa = $empresa->getEmpresaId($this->rfc, $this->digito);
        $view = new ViewModel(array('Empresa'=>$empresa));
        $view->setTerminal(true);
        return $view;
    }
    
    public function vacantesAction(){
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $vacantes = new \Administrador\Model\Vacantes($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $vacantes->updatevacante($post["id_rfc"], $post["digito_verificador"], $post["num_vacante"], $post);
        }
        $paginator = $vacantes->getvacantesIdwhere("e.id_rfc='$this->rfc' AND e.digito_verificador='$this->digito' AND fecha_hora_actualizacion> NOW()- interval 3 month");
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 8
        $paginator->setItemCountPerPage(8);
        $view = new ViewModel(array(
            'paginator' => $paginator
        ));
        $view->setTerminal(true);
        return $view;
    }

}
