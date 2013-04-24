<?php
// src/Acme/DemoBundle/Menu/Builder.php
namespace THL\OnCallBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('This month', array('route' => 'thl_oncall_default_index'));
        $menu->addChild('This week', array('route' => 'thl_oncall_default_week'));
        $adminMenu = $menu->addChild('Admin', array('uri' => '#'));
        $adminMenu->addChild('Actors', array('route'=>'actor'));
        $adminMenu->addChild('Schedule', array('route'=>'schedule'));
        ;
//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        // ... add more children

        return $menu;
    }
}