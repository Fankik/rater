<?php

namespace Application\Helpers\Slug;

use Doctrine\Persistence\ManagerRegistry;

final readonly class SlugGenerator
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {
    }

    /** @param class-string $entityClass */
    public function generateUniqueSlug(string $entityClass, string $key = 'slug'): string
    {
        $slug = self::generateRandomString();

        $entityManager = $this->managerRegistry->getManagerForClass($entityClass);

        if (!$entityManager) {
            throw new \RuntimeException(sprintf('No entity manager found for class "%s"', $entityClass));
        }

        $entityRepository = $entityManager->getRepository($entityClass);

        while ($entityRepository->findOneBy([$key => $slug])) {
            $slug = self::generateRandomString();
        }

        return $slug;
    }

    private static function generateRandomString(): string
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            (int) ceil(10 / 62),
        )), 0, 10);
    }
}
