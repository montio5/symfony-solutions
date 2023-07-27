<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Hotel;
use App\SearchService\Search;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;

class SearchTest extends KernelTestCase
{
    // to create kernel class
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testIntegrationSearch(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $hotelRepo = $entityManager->getRepository(Hotel::class);


        $hotel1 = new Hotel();
        $hotel1->setName("abcd");
        $hotel1->setAddress("address");

        $hotel2 = new Hotel();
        $hotel2->setName("cdef");
        $hotel2->setAddress("address");

        $hotelRepo->save($hotel1);
        $hotelRepo->save($hotel2, true);

        $hotelSearchService = static::getContainer()->get(Search::class);
        $this->assertInstanceOf(Search::class, $hotelSearchService);

        $result = $hotelSearchService->search("ab");
        $this->assertContains($hotel1, $result);
        $this->assertNotContains($hotel2, $result);

        $result = $hotelSearchService->search("ef");
        $this->assertContains($hotel2, $result);
        $this->assertNotContains($hotel1, $result);

        $result = $hotelSearchService->search("cd");
        $this->assertContains($hotel1, $result);
        $this->assertContains($hotel2, $result);
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
