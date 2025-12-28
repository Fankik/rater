<?php

namespace Infrastructure\CodeStyle\PHPStan\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

final class ObjectManagerForPhpStan implements ObjectManager
{
    private ?ClassMetadataFactoryForPhpStan $classMetadataFactory = null;

    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {
    }

    /** {@inheritDoc} */
    public function find(string $className, mixed $id): ?object
    {
        return $this->getManagerForClass($className)->find($className, $id);
    }

    /** {@inheritDoc} */
    public function persist(object $object): void
    {
        $this->getManagerForClass($object::class)->persist($object);
    }

    /** {@inheritDoc} */
    public function remove(object $object): void
    {
        $this->getManagerForClass($object::class)->remove($object);
    }

    /** {@inheritDoc} */
    public function clear(): void
    {
        foreach ($this->managerRegistry->getManagers() as $manager) {
            $manager->clear();
        }
    }

    /** {@inheritDoc} */
    public function detach(object $object): void
    {
        $this->getManagerForClass($object::class)->detach($object);
    }

    /** {@inheritDoc} */
    public function refresh(object $object): void
    {
        $this->getManagerForClass($object::class)->refresh($object);
    }

    /** {@inheritDoc} */
    public function flush(): void
    {
        foreach ($this->managerRegistry->getManagers() as $manager) {
            $manager->flush();
        }
    }

    /** {@inheritDoc} */
    public function getRepository(string $className): ObjectRepository
    {
        return $this->getManagerForClass($className)->getRepository($className);
    }

    /** {@inheritDoc} */
    public function getClassMetadata(string $className): ClassMetadata
    {
        return $this->getManagerForClass($className)->getClassMetadata($className);
    }

    /** {@inheritDoc} */
    public function getMetadataFactory(): ClassMetadataFactory
    {
        if ($this->classMetadataFactory === null) {
            $this->classMetadataFactory = new ClassMetadataFactoryForPhpStan($this->managerRegistry);
        }

        return $this->classMetadataFactory;
    }

    /** {@inheritDoc} */
    public function initializeObject(object $obj): void
    {
        $this->getManagerForClass($obj::class)->initializeObject($obj);
    }

    /** {@inheritDoc} */
    public function contains(object $object): bool
    {
        return $this->getManagerForClass($object::class)->contains($object);
    }

    /**
     * @param class-string $className
     */
    private function getManagerForClass(string $className): ObjectManager
    {
        return $this->managerRegistry->getManagerForClass($className) ?? $this->managerRegistry->getManager();
    }
}
