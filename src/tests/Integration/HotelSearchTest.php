<?php

namespace App\Tests\Integration;

use App\Entity\Hotel;
use App\Hotel\SearchService;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HotelSearchTest extends KernelTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());


        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $hotelRepo = $entityManager->getRepository(Hotel::class);


        $hotel1 = new Hotel();
        $hotel1->setName("hotel1");
        $hotel1->setAddress("address1");
        $hotel1->setPhone("654654");
        $hotel1->setEmail("test@gmail.com");

        $hotel2 = new Hotel();
        $hotel2->setName("hotel2");
        $hotel2->setAddress("address2");
        $hotel2->setPhone("65465433");
        $hotel2->setEmail("admin@gmail.com");

        $hotelRepo->save($hotel1);
        $hotelRepo->save($hotel2, true);

        $hotelSearchService = static::getContainer()->get(SearchService::class);
        $this->assertInstanceOf(SearchService::class, $hotelSearchService);

        $result = $hotelSearchService->search("1");
        $this->assertContains($hotel1, $result);
        $this->assertNotContains($hotel2, $result);

        $result = $hotelSearchService->search("2");
        $this->assertContains($hotel2, $result);
        $this->assertNotContains($hotel1, $result);

        $result = $hotelSearchService->search("hotel");
        $this->assertContains($hotel1, $result);
        $this->assertContains($hotel2, $result);
    }
}