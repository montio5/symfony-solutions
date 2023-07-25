<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;

class HotelTest extends WebTestCase
{
//    protected static function getKernelClass(): string
//    {
//        return \App\Kernel::class;
//    }
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hotel/');

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        /** @var HotelRepository $hotelRepo */
        $hotelRepo = $entityManager->getRepository(Hotel::class);

        $allHotels = $hotelRepo->findAll();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hotel index');

        $rows = $crawler->filter('table > tbody > tr');
        $this->assertCount(count($allHotels), $rows);
    }
}
