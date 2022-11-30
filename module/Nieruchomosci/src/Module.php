<?php

namespace Nieruchomosci;

use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\InitProviderInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;
use Nieruchomosci\Model\Koszyk;

class Module implements ConfigProviderInterface, InitProviderInterface, BootstrapListenerInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function init(ModuleManagerInterface $manager)
    {
        $manager->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
            MvcEvent::EVENT_DISPATCH, function (MvcEvent $e) {
                // zmiana domyślengo layotu dla modułu Nieruchomosci
                $e->getTarget()->layout('layout/nieruchomosci');

                // przypisanie liczby ofert w koszyku do view model layoutu
                $e->getViewModel()->liczba_ofert = $e->getApplication()
                    ->getServiceManager()
                    ->get(Koszyk::class)
                    ->liczbaOfert();
            }
        );
    }

    public function onBootstrap(EventInterface $e)
    {
        // uruchom sesje
        $session = new SessionManager();
        $session->start();
    }
}
