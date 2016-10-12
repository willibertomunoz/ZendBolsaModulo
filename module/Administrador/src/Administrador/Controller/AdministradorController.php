<?php

namespace Administrador\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

class AdministradorController extends AbstractActionController {

    private $alumno = null;
    private $dbAdapter;
    private $auth, $datos, $layout, $usuario, $get;

    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
//        $this->auth = new AuthenticationService();
//        $identi = $this->auth->getStorage()->read();
        $this->usuario = new Container("usuario");
//        if ($identi != false && $identi != null && !is_null($this->usuario->id)) {
//            $this->datos = $identi;
//            $this->layout = $this->layout();
//            $this->layout->setTemplate('layout/Alumno');
//            $this->usuario->setExpirationSeconds(800);
//        }
    }

    public function indexAction() {
        $this->layout = $this->layout();
        $this->usuario = new Container("usuario");
        $this->layout->setTemplate('layout/Administrador');
        if (!is_null($this->usuario->script)) {
            $this->layout->script = $this->usuario->script;
//            $this->usuario->script = NULL;
        }
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $ingresos = new \Administrador\Model\Ingresos($this->dbAdapter);
        $ingresos = $ingresos->getInformacionIndex();
        return new ViewModel(array(
            'ingresos' => $ingresos
        ));
    }

    public function empresaPendienteAction() {
        $this->verfica("empresapendiente");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $empresa = new \Administrador\Model\Empresa($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $empresa->updateEmpresa($post["id_rfc"], $post["digito_verificador"], $post);
        }
        $where = "autorizacion =0";
        $paginator = $empresa->getEmpresaWhere($where);
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

    public function empresaRechazadaAction() {
        $this->verfica("empresarechazada");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $alumno = new \Administrador\Model\Empresa($this->dbAdapter);
        $where = "autorizacion =2 ";
        $paginator = $alumno->getEmpresaWhere($where);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 8
        $paginator->setItemCountPerPage(7);
//        $paginator = $alumno->getPostulaciones();
        $view = new ViewModel(array(
            'paginator' => $paginator
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function empresaActivasAction() {
        $this->verfica("empresaactivas");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $empresa = new \Administrador\Model\Empresa($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $empresa->updateEmpresa($post["id_rfc"], $post["digito_verificador"], $post);
        }
        $where = "autorizacion =1";
        $paginator = $empresa->getEmpresaWhere($where);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 8
        $paginator->setItemCountPerPage(5);
//        $paginator = $alumno->getPostulaciones();
        $view = new ViewModel(array(
            'paginator' => $paginator
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function vacantePendienteAction() {
        $this->verfica("vacantependiente");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $vacantes = new \Administrador\Model\Vacantes($this->dbAdapter);
        $paginator = $vacantes->getvacantesIdwhere("status=0 AND fecha_hora_actualizacion> NOW()- interval 3 month");
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

    public function vacanteRechazadaAction() {
        $this->verfica("vacanterechazada");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $vacantes = new \Administrador\Model\Vacantes($this->dbAdapter);

        $paginator = $vacantes->getvacantesIdwhere("status=2 AND fecha_hora_actualizacion> NOW()- interval 3 month");
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

    public function vacanteActivaAction() {
        $this->verfica("vacanteactiva");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        $vacantes = new \Administrador\Model\Vacantes($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $vacantes->updatevacante($post["id_rfc"], $post["digito_verificador"], $post["num_vacante"], $post);
        }
        $paginator = $vacantes->getvacantesIdwhere("status=1 AND fecha_hora_actualizacion> NOW()- interval 3 month");
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

    public function AlumnosAction() {
        $this->verfica("alumnos");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $login_alumno = new \Administrador\Model\LogIn($this->dbAdapter);
            $login_alumno->updateLogin($post["id_rfc"], "", $post);
        }
        $alumno = new \Alumno\Model\AlumnoDatosPersonales($this->dbAdapter);
        $paginator = $alumno->getAlumnoPaginator();
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

    public function imagenesAction() {
        $this->verfica("imagenes");
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $imagenesClass = new \Administrador\Model\Imagenes($this->dbAdapter);
            if ($post["accion"] == "actualiza") {
                unset($post["accion"]);
                echo '<script>parent.fnrecarga();</script>';
                $imagenesClass->updateImagenes($post["id_imagen"], $post);
                echo '<script>parent.fnrecarga();</script>';
                $view = new ViewModel();
                $view->setTerminal(false);
                exit();
            } else {
                $imagen = $post["imagen"];
                unset($post["imagen"]);

                $imagenesClass->addImagenes($post);
                $Nimagen = $imagenesClass->lastImagen();
                $Nimagen = $Nimagen["Nimagen"];
                $filter = new \Zend\Filter\File\Rename(
                        array(
                    "source" => $imagen,
                    "target" => "./public/img/$Nimagen.jpg",
                    "overwrite" => true,
                ));
                echo $filter->filter($imagen);
            }
            return true;
        } else {
            $imagenes = new \Administrador\Model\Imagenes($this->dbAdapter);
            $paginator = $imagenes->getImagenPaginator();
            // set the current page to what has been passed in query string, or to 1 if none set
            $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
            // set the number of items per page to 8
            $paginator->setItemCountPerPage(5);
            $view = new ViewModel(array(
                'paginator' => $paginator
            ));
            $view->setTerminal(true);
            return $view;
        }
    }

    public function carreraAction() {
        $this->verfica("carrera");
        //$form = new \Administrador\Form\CarreraForm();
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            
            $carrera = new \Administrador\Model\Carrera($this->dbAdapter);
            $accion = $post["accion"];
            unset($post["accion"]);
            if ($accion == "actualiza") {
                $carrera->updateCarrera($post["id_carrera"], $post);
            } else {
                $carrera->addCarrera($post);
            }
            echo "<script>parent.fnrecarga();</script>";
        }
        $carrera = new \Administrador\Model\Carrera($this->dbAdapter);
        $paginator = $carrera->getcarreraPaginator();
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

    public function idiomasAction() {
        $this->verfica("idiomas");
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

    public function horarioAction() {
        $this->verfica("horario");
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

//    public function registrarAction() {
//        $view = new ViewModel();        $view->setTerminal(true);        return $view;
//    }
    public function mostrarAction() {
        $this->verfica("mostrar");
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

//    public function modificarAction() {
//        $view = new ViewModel();        $view->setTerminal(true);        return $view;
//    }
//    public function eliminarAction() {
//        $view = new ViewModel();        $view->setTerminal(true);        return $view;
//    }
    public function reportesAction() {
        $this->verfica("reportes");
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

    public function empresaidAction() {
//        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $empresa = new \Administrador\Model\Empresa($this->dbAdapter);
            $empre = $empresa->getEmpresaId($post["id_rfc"], $post["digito_verificador"]);
        }
        $view = new ViewModel(array(
            'empresa' => $empre,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function vacanteidAction() {
//        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $v = new \Administrador\Model\Vacantes($this->dbAdapter);
            $vacante = $v->getvacanteNumVacante($post["id_rfc"], $post["digito_verificador"], $post["num_vacante"]);
        }
        $view = new ViewModel(array(
            'vacante' => $vacante,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function alumnocuentaAction() {
//        $this->usuario->setExpirationSeconds(800);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost()->toArray();
            $alumno = new \Alumno\Model\AlumnoDatosPersonales($this->dbAdapter);
            $alum = $alumno->getAlumnoCuenta($post["id_cuenta"]);
            $login = new \Administrador\Model\LogIn($this->dbAdapter);
            $log = $login->getLoginId($post["rfc"], "");
        }
        $view = new ViewModel(array(
            'alumno' => $alum,
            'login' => $log,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function cerrarAction() {
        //Cerramos la sesión borrando los datos de la sesión.
        $this->flashMessenger()->addMessage("Sesion finalizada, inicie de nuevo");
//        $this->usuario->setExpirationSeconds(0);
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/');
    }

    public function verfica($url) {
        $this->usuario = new Container("usuario");
        if ($this->getRequest()->isGet() && !$this->getRequest()->isXmlHttpRequest()) {
            if (is_null($this->usuario->script)) {
                $this->usuario->script = '$("#main-content").load("' . $url . '");'
                        . 'history.pushState(null, null, "' . $url . '");';
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/Administrador/');
            } else {
                $this->usuario->script = NULL;
            }
        } else {
            $this->usuario->script = NULL;
        }
    }

}
