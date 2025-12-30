<?php

namespace Application\Security\PasswordHasher;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
}
