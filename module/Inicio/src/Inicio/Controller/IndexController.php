<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Inicio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Inicio\Form\LoginForm;
//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
//use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
//db
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

//use Zend\Validator;
//use Zend\I18n\Validator as I18nValidator;
//use Zend\Db\Adapter\Adapter;
//use Zend\Crypt\Password\Bcrypt;

class IndexController extends AbstractActionController {

    private $dbAdapter;
    private $auth, $nSession = 12;

    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function misionAction() {
        return new ViewModel();
    }

    public function visionAction() {
        return new ViewModel();
    }

    public function objetivosAction() {
        return new ViewModel();
    }

    public function contactanosAction() {
        return new ViewModel();
    }

    public function practicasAction() {
        return new ViewModel();
    }

    public function loginAction() {
        $auth = $this->auth;
        $usuario = new Container("usuario");
        $usuario->setExpirationSeconds(20);
        $identi = $auth->getStorage()->read();
        $modal = NULL;
        if (!is_null($usuario->id) && $identi->status == 1) {
            $this->redirigir($identi->tipo_usuario);
        }
        //DbAdapter
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

        //Creamos el formulario de login
        $form = new LoginForm("form");

        //Si nos llegan datos por post
        if ($this->getRequest()->isPost()) {

            /* Creamos la autenticación a la que le pasamos:
              1. La conexión a la base de datos
              2. La tabla de la base de datos
              3. El campo de la bd que hará de username
              4. El campo de la bd que hará de contraseña
             */
            $authAdapter = new AuthAdapter($this->dbAdapter, 'log_in', 'id_rfc', 'password'
            );

            /*
              Podemos hacer lo mismo de esta manera:
              $authAdapter = new AuthAdapter($dbAdapter);
              $authAdapter
              ->setTableName('users')
              ->setIdentityColumn('username')
              ->setCredentialColumn('password');
             */

            /*
              En el caso de que la contraseña en la db este cifrada
              tenemos que utilizar el mismo algoritmo de cifrado
             */
//            $bcrypt = new Bcrypt(array(
//                                'salt' => 'aleatorio_salt_pruebas_victor',
//                                'cost' => 5));
//            
//            $securePass = $bcrypt->create($this->request->getPost("password"));
            //Establecemos como datos a autenticar los que nos llegan del formulario
            $authAdapter->setIdentity($this->getRequest()->getPost("id_rfc"))
                    ->setCredential($this->getRequest()->getPost("password"));


            //Le decimos al servicio de autenticación que el adaptador
            $auth->setAdapter($authAdapter);

            //Le decimos al servicio de autenticación que lleve a cabo la identificacion
            $result = $auth->authenticate();

            //Si el resultado del login es falso, es decir no son correctas las credenciales
            if ($authAdapter->getResultRowObject() == false) {

                //Crea un mensaje flash y redirige
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intentalo de nuevo");
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
            } else {
                // Le decimos al servicio que guarde en una sesión 
                // el resultado del login cuando es 
                $usuario->id = $this->nSession++;
                $auth->getStorage()->write($authAdapter->getResultRowObject());
                $modal = $this->redirigir($authAdapter->getResultRowObject()->tipo_usuario, $authAdapter->getResultRowObject()->status);
//                echo $usuario->id;
            }
        }
        $us = NULL;
        if (!is_null($identi))
            if (!is_null($identi->id_rfc))
                $us = $identi->id_rfc;
        return new ViewModel(
                array("form" => $form, "rfc" => $us, "modal" => $modal)
        );
    }

    private function redirigir($usuario, $status) {
        if ($status == 0) {
            $this->flashMessenger()->addMessage("Usuario esta dada de baja, contacte al administrador");
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
        }
        switch ($usuario) {
            case 1:
                //Nos redirige a una pagina interior
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/Alumno/');
                break;
            case 2:
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/Administrador/');
                break;
            case 3:
                return true;
                break;
        }
    }

    public function empresaAction() {
        $view = new ViewModel();
        $post = $this->getRequest()->getPost()->toArray();
        $auth = $this->auth;
        $identi = $auth->getStorage()->read();
        if ($identi->digito_verificador == $post["digito"]) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/Empresa/');
        } else {
            $this->flashMessenger()->addMessage("Numero Verificador erroneo, intentalo de nuevo");
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/login');
        }
        $view->setTerminal(true);
    }

}
