<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\RegisteredIdentifier;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Test\Utils\Dsl\Party\Domain\Party\AssertRegisteredIdentifierCollection;
use Test\Utils\Dsl\Party\Domain\Party\RegisteredIdentifierCollectionBuilder;

final class RegisteredIdentifierCollectionTest extends TestCase
{
    #[Test]
    public function newCollectionIsAlwaysEmpty(): void
    {
        $sut = RegisteredIdentifierCollectionBuilder::aRegisteredIdentifiersWith();

        AssertRegisteredIdentifierCollection::aCollection($sut)
            ->isEmpty();
    }

    #[Test]
    public function canAddNewItemToCollection(): void
    {
        $item = new FakeRegisteredIdentifier('1');
        $sut = RegisteredIdentifierCollectionBuilder::aRegisteredIdentifiersWith();

        $result = $sut->add($item);

        Assert::assertTrue($result->isSuccess());
        AssertRegisteredIdentifierCollection::aCollection($sut)
            ->contains($item);
    }

    #[Test]
    public function canNotAddSameItemTwiceToCollection(): void
    {
        $item = new FakeRegisteredIdentifier('1');
        $sut = RegisteredIdentifierCollectionBuilder::aRegisteredIdentifiersWith($item);

        $result = $sut->add($item);

        Assert::assertTrue($result->isSkipped());
        AssertRegisteredIdentifierCollection::aCollection($sut)
            ->contains($item);
    }

    #[Test]
    public function canRemoveItemFromCollection(): void
    {
        $item = new FakeRegisteredIdentifier('1');
        $sut = RegisteredIdentifierCollectionBuilder::aRegisteredIdentifiersWith($item);

        $result = $sut->remove($item);

        Assert::assertTrue($result->isSuccess());
        AssertRegisteredIdentifierCollection::aCollection($sut)
            ->isEmpty();
    }

    #[Test]
    public function canNotRemoveNotExistingItemFromCollection(): void
    {
        $item1 = new FakeRegisteredIdentifier('1');
        $item2 = new FakeRegisteredIdentifier('2');
        $sut = RegisteredIdentifierCollectionBuilder::aRegisteredIdentifiersWith($item1);

        $result = $sut->remove($item2);

        Assert::assertTrue($result->isSkipped());
        AssertRegisteredIdentifierCollection::aCollection($sut)
            ->hasCount(1)
            ->contains($item1);
    }
}
