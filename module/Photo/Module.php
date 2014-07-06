<?php

namespace Photo;

class Module {

    /**
     * Get the autoloader configuration.
     *
     * @return array Autoloader config
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }

    /**
     * Get the configuration for this module.
     *
     * @return array Module configuration
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get service configuration.
     *
     * @return array Service configuration
     */
    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'photo_service_album' => 'Photo\Service\Album',
                'photo_service_photo' => 'Photo\Service\Photo'
            ),
            'factories' => array(
                'photo_mapper_album' => function ($sm) {
            return new Mapper\Album(
                    $sm->get('photo_doctrine_em')
            );
        },
                // fake 'alias' for entity manager, because doctrine uses an abstract factory
                // and aliases don't work with abstract factories
                // reused code from the eduction module
                'photo_doctrine_em' => function ($sm) {
            return $sm->get('doctrine.entitymanager.orm_default');
        }
            )
        );
    }

}
