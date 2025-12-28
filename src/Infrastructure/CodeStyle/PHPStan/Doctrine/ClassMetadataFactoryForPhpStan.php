<?php

namespace Infrastructure\CodeStyle\PHPStan\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\Persistence\ObjectManager;

final class ClassMetadataFactoryForPhpStan implements ClassMetadataFactory
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {
    }

    /** {@inheritDoc} */
    public function getAllMetadata(): array
    {
        $allMetadataGroups = [];

        foreach ($this->managerRegistry->getManagers() as $manager) {
            $allMetadataGroups = $manager->getMetadataFactory()->getAllMetadata();
        }

        return array_merge(...$allMetadataGroups);
    }

    /** {@inheritDoc} */
    public function getMetadataFor(string $className): ClassMetadata
    {
        return $this->getManagerForClass($className)->getMetadataFactory()->getMetadataFor($className);
    }

    /** {@inheritDoc} */
    public function hasMetadataFor(string $className): bool
    {
        return $this->getManagerForClass($className)->getMetadataFactory()->hasMetadataFor($className);
    }

    /** {@inheritDoc} */
    public function setMetadataFor(string $className, ClassMetadata $class): void
    {
        $this->getManagerForClass($className)->getMetadataFactory()->setMetadataFor($className, $class);
    }

    /** {@inheritDoc} */
    public function isTransient(string $className): bool
    {
        return $this->getManagerForClass($className)->getMetadataFactory()->isTransient($className);
    }

    /**
     * @param class-string $className
     */
    private function getManagerForClass(string $className): ObjectManager
    {
        return $this->managerRegistry->getManagerForClass($className) ?? $this->managerRegistry->getManager();
    }
}
