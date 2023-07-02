<?php

namespace App\Menu;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{

    private $factory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        FactoryInterface       $factory,
        EntityManagerInterface $entityManager
    )
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    public function mainMenu(RequestStack $requestStack): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_home_home']);
        $menu->addChild('About us', ['route' => 'app_home_about']);
        $menu->addChild('Contact us', ['route' => 'app_message_new']);
        $menu->addChild('Hotels', ['route' => 'app_hotel_index']);


        /** @var Hotel[] $hotels */
        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();

        foreach ($hotels as $hotel) {
            $menu['Hotels']->addChild($hotel->getName(), [
                'route' => 'app_hotel_show',
                'routeParameters' => ['id' => $hotel->getId()],
            ]);
        }

        $menu->addChild('Users', ['route' => 'app_user_index']);
        $menu->addChild('Login', ['route' => 'app_login']);
        $menu->addChild('Logout', ['route' => 'app_logout']);
        $menu->addChild('Register', ['route' => 'app_register']);

        return $menu;
    }
}
