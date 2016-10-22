<?php

return array(
    'controllers'=>array(
        'invokables'=>array(
            'Empresa\Controller\Empresa'=>'Empresa\Controller\EmpresaController'
         ),
     ),
     
     'router'=>array(
        'routes'=>array(
            'Empresa'=>array(
                 'type'=>'Segment',
                    'options'=>array(
                        
                        'route' => '/Empresa[/[:action]]',
                        'constraints' => array(
                                'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                        
                        'defaults'  =>  array(
                                'controller' => 'Empresa\Controller\Empresa',
                                'action'     => 'index'
                         
                        ),
                    ),
           ),
       ),
    ),
    
   //Cargamos el view manager
   'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/Empresa.phtml',
            'Empresa/index/index' => __DIR__ . '/../view/empresa/empresa/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
          'Empresa' =>  __DIR__ . '/../view',
        ),
    ), 
 );                               