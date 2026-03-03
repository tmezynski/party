<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Organisation;

use Party\Domain\Party\Organisation\Event\OrganisationNameUpdated;
use Party\Domain\Party\Organisation\Event\OrganisationNameUpdateSkipped;
use Party\Domain\Party\Organisation\OrganisationName;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Test\Utils\Dsl\Party\Domain\Party\AssertOrganisation;
use Test\Utils\Dsl\Party\Domain\Party\OrganisationBuilder;

final class OrganisationTest extends TestCase
{
    #[Test]
    public function canNotUpdateOrganisationWithTheSameName(): void
    {
        $organisationName = new OrganisationName('Test');
        $sut = OrganisationBuilder::anOrganisation()
            ->withOrganisationName($organisationName)
            ->build();

        $result = $sut->updateOrganisationName($organisationName);

        Assert::assertTrue($result->isSkipped());
        AssertOrganisation::assertThat($sut)
            ->recordedEvent(new OrganisationNameUpdateSkipped((string)$sut->id(), 'Test'));
    }

    #[Test]
    public function canUpdateOrganisationWithDifferentName(): void
    {
        $oldOrganisationName = new OrganisationName('Test');
        $newOrganisationName = new OrganisationName('New Name');
        $sut = OrganisationBuilder::anOrganisation()
            ->withOrganisationName($oldOrganisationName)
            ->build();

        $result = $sut->updateOrganisationName($newOrganisationName);

        Assert::assertTrue($result->isSuccess());
        AssertOrganisation::assertThat($sut)
            ->recordedEvent(new OrganisationNameUpdated((string)$sut->id(), 'New Name'));
    }
}
