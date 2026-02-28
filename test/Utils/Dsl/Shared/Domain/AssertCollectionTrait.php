<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared\Domain;

use PHPUnit\Framework\Assert;
use ReflectionClass;

trait AssertCollectionTrait
{
    /**
     * @var ReflectionClass<object>
     */
    private ReflectionClass $reflection;

    private object $object;

    private function setReflection(object $object): void
    {
        $this->object = $object;
        $this->reflection = new ReflectionClass($object);
    }

    public function isEmpty(): self
    {
        return $this->hasCount(0);
    }

    public function hasCount(int $expected): self
    {
        /** @var object[] $items */
        $items = $this->getProperty('items');
        Assert::assertCount($expected, $items);

        return $this;
    }

    public function contains(object ...$expectedItems): self
    {
        foreach ($expectedItems as $expectedItem) {
            Assert::assertTrue(
                $this->reflection
                    ->getMethod('contains')
                    ->invokeArgs($this->object, [$expectedItem]),
            );
        }

        return $this;
    }

    private function getProperty(string $name): mixed
    {
        $property = $this->reflection->getProperty($name);

        return $property->getValue($this->object);
    }
}
