<?php

return array(
    'controllers'=>array(
        'invokables'=>array(
            'Memo\Controller\Memo'=>'Memo\Controller\MemoController'
         ),
     ),
     
     'router'=>array(
        'routes'=>array(
            'memo'=>array(
                 'type'=>'Segment',
                    'options'=>array(
                        
                        'route' => '/memo[/[:action]]',
                        'constraints' => array(
                                'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                        
                        'defaults'  =>  array(
                                'controller' => 'Memo\Controller\Memo',
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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'memo/index/index' => __DIR__ . '/../view/memo/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
          'memo' =>  __DIR__ . '/../view',
        ),
    ), 
 );                               