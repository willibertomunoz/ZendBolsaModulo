<?php

namespace Alumno\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Alumno\Model\Alumno;
use Administrador\Model\Vacantes;
use Zend\Http\PhpEnvironment\Request;
use Alumno\Form\AlumnoDireccionForm;
//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\File\Transfer\Adapter\Http;

class AlumnoController extends AbstractActionController {

    private $alumno = null;
    private $dbAdapter;
    private $auth, $datos, $layout, $usuario;

    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
        $identi = $this->auth->getStorage()->read();
        $this->usuario = new Container("usuario");
        if ($identi != false && $identi != null && !is_null($this->usuario->id) && $identi->tipo_usuario == 1) {
            $this->datos = $identi;
            $this->layout = $this->layout();
            $this->layout->setTemplate('layout/Alumno');
            $this->usuario->setExpirationSeconds(800);
        }
    }

    public function indexAction() {
        if (is_null($this->usuario->id) || $this->datos->tipo_usuario != 1) {
            echo is_null($this->usuario->id) . $this->datos->tipo_usuario;
            $this->flashMessenger()->addMessage("Sesion finalizada, inicie de nuevo");
            $this->usuario->setExpirationSeconds(0);
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/Alumno');
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        $layout->nombre = $this->alumno->getAtributo("nombre");
        $layout->carrera = $this->alumno->getAtributo("carrera");
        $layout->rfc = $this->datos->id_rfc;
        $v = new Vacantes($this->dbAdapter);
        $vac = $v->getvacantes();
        $view = new ViewModel(array(
            'vacantes' => $vac,
        ));
//        $view->setTerminal(true);
        return $view;
    }

    public function direccionAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $this->alumno->updateDatosTabla($post, "direccion");
        }
        $form = new AlumnoDireccionForm($this->alumno, $this->dbAdapter);
        $view = new ViewModel(array(
            'form' => $form,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function vacantesAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            if (is_null($post["where"])) {
                $this->alumno->insertDatosTabla($post, "interesados");
            } else {
                $vacantes = new Vacantes($this->dbAdapter);
                $paginator = $vacantes->getvacantesIdwhere($post["where"]);
            }
        } else {
            $vacantes = new Vacantes($this->dbAdapter);
            $paginator = $vacantes->getvacantesId($this->alumno->getAtributo("id_carrera"));
        }
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

    public function postulacionesAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        $paginator = $alumno->getPostulaciones();
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 8
        $paginator->setItemCountPerPage(8);
//        $paginator = $alumno->getPostulaciones();
        $view = new ViewModel(array(
            'paginator' => $paginator
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function curriculumAction() {
        $this->usuario->setExpirationSeconds(800);
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function datospersonalesAction() {
        $this->usuario->setExpirationSeconds(800);
        $URL = $this->getRequest()->getBaseUrl() . '/';
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {

            $request = $this->getRequest();
            // Make certain to merge the files info!
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );
            $rfc = $this->datos->id_rfc;
            $imagen = $post["imagen"];
            unset($post["imagen"]);
            $this->alumno->updateDatosTabla($post, "DatosPersonales");
            $filter = new \Zend\Filter\File\Rename(
                    array(
                "source" => $imagen,
                "target" => "./data/img/$rfc.jpg",
                "overwrite" => true,
            ));
            echo $filter->filter($imagen);
        }

        $form = new \Alumno\Form\DatosPersonalesForm($this->alumno);
        $view = new ViewModel(array(
            'form' => $form,
            'rfc' => $this->datos->id_rfc
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function datosacademicosAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $this->alumno->updateDatosTabla($post, "DatosAcademicos");
        }
        $form = new \Alumno\Form\DatosAcademicosForm($this->alumno, $this->dbAdapter);
        $view = new ViewModel(array(
            'form' => $form,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function referenciaslaboralesAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            if (!empty($post["eliminar"])) {
                unset($post["eliminar"]);
                $this->alumno->deleteDatosTabla($post, "ReferenciaLaboral");
            } else {
                $this->alumno->insertDatosTabla($post, "ReferenciaLaboral");
            }
        }
        $paginator = $this->alumno->getReferenciasLaborales();
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 8));
        $paginator->setItemCountPerPage(8);
        $form = new \Alumno\Form\ReferenciaLaboralesForm();
        $view = new ViewModel(array(
            'paginator' => $paginator,
            'form' => $form
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function datoscomplementariosAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $this->alumno->updateDatosTabla($post, "PreferenciaLaboral");
        }
        $form = new \Alumno\Form\PreferenciaLaboralesForm($this->alumno, $this->dbAdapter);
        $view = new ViewModel(array(
            'form' => $form,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function idiomasAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            echo $post["eliminar"];
            if (!empty($post["eliminar"])) {
                unset($post["eliminar"]);
                $this->alumno->deleteDatosTabla($post, "idiomas");
            } else {
                $this->alumno->insertDatosTabla($post, "idiomas");
            }
        }
        $paginator = $this->alumno->getIdiomas();
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 8));
        $paginator->setItemCountPerPage(8);
        $form = new \Alumno\Form\IdiomasForm($this->dbAdapter);
        $view = new ViewModel(array(
            'paginator' => $paginator,
            'form' => $form
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function passwordAction() {
        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $this->alumno = Alumno::getInstance($this->datos->id_rfc, $this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $this->alumno->updateDatosTabla($post, "Log_In");
        }
        $form = new \Alumno\Form\PasswordForm();
        $viewModel = new ViewModel(array(
            'form' => $form,
            'pass_actual' => $this->alumno->getAtributoTabla("Log_In")["password"],
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function cerrarAction() {
        //Cerramos la sesión borrando los datos de la sesión.
        $this->flashMessenger()->addMessage("Sesion finalizada, inicie de nuevo");
        $this->usuario->setExpirationSeconds(0);
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/');
    }

    public function vacanteidAction() {
//        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $v = new Vacantes($this->dbAdapter);
            $vacante = $v->getvacanteNumVacante($post["id_rfc"], $post["digito_verificador"], $post["num_vacante"]);
        }
        $view = new ViewModel(array(
            'vacante' => $vacante,
        ));
        $view->setTerminal(true);
        return $view;
    }

}
