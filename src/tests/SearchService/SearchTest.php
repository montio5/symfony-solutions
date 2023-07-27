<?php

namespace App\Tests\SearchService;

use App\Entity\Hotel;
use App\SearchService\Search;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function testSearchHotel(): void
    {
        $hotel = new Hotel();
        $hotel->setName("Hotel 1");

        // mock the repository
        $hotelRepository = $this->createMock(HotelRepository::class);
        $hotelRepository->expects($this->exactly(1))
            ->method('searchByName')
            ->with("1234")
            ->willReturn([$hotel]);

        // mock the entity manager
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->exactly(1))
            ->method('getRepository')
            ->with(Hotel::class)
            ->willReturn($hotelRepository);

        $searchService = new Search($entityManager);
        $result = $searchService->searchHotel("1234");

        $this->assertContains($hotel, $result);
//        $this->assertTrue(true);
    }
}
