<?php

namespace Tests\Domain\RateSpace\Query\Handlers;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Exceptions\RateSpaceNotFoundException;
use Domain\RateSpace\Query\GetRateSpaceByIdQuery;
use Symfony\Component\Uid\Uuid;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class GetRateSpaceByIdQueryHandlerTest extends FunctionalTestCase
{
    public function testUserMustBeGet(): void
    {
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $query = new GetRateSpaceByIdQuery(
            id: $rateSpace->getId(),
        );

        $findRateSpace = $this->getQueryBus()->dispatch($query);

        assert($findRateSpace instanceof RateSpace);

        self::assertTrue($rateSpace->getId()->equals($findRateSpace->getId()));
    }

    public function testThrowExceptionWhenUserIsNotFound(): void
    {
        $this->expectException(RateSpaceNotFoundException::class);

        $rateSpaceId = Uuid::v7();

        $query = new GetRateSpaceByIdQuery(
            id: $rateSpaceId,
        );

        $this->getQueryBus()->dispatch($query);
    }
}
