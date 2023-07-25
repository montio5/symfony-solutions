<?php

namespace App\Tests\Hotel;

use App\Entity\Hotel;
use App\Hotel\SearchService;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class SearchServiceTest extends TestCase
{
    public function testSomething(): void
    {
        $hotel = new Hotel();
        $hotel->setName("Hotel 1");

        $hotelRepository = $this->createMock(HotelRepository::class);
        $hotelRepository->expects($this->exactly(1))
            ->method('searchByName')
            ->with("1234")
            ->willReturn([$hotel]);

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->with(Hotel::class)
            ->willReturn($hotelRepository);

        $searchService = new SearchService($entityManager);
        $result = $searchService->search("1234");

        $this->assertContains($hotel, $result);
    }
}
