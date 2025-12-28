<?php

namespace Infrastructure\CodeStyle\PHPStan;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertiesNode;
use PhpParser\Node;
use PHPStan\Reflection\ConstructorsHelper;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

final readonly class MissingReadOnlyPropertyAssignRule implements Rule
{
    public function __construct(
        private ConstructorsHelper $constructorsHelper,
    ) {
    }

    public function getNodeType(): string
    {
        return ClassPropertiesNode::class;
    }

    /**
     * {@inheritDoc}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof ClassPropertiesNode) {
            return [];
        }

        $classReflection = $node->getClassReflection();
        [$properties, $prematureAccess, $additionalAssigns] = $node->getUninitializedProperties($scope, $this->constructorsHelper->getConstructors($classReflection));
        $errors = [];

        $methods = $node->getClass()->getMethods();

        foreach ($properties as $propertyName => $propertyNode) {
            if (!$propertyNode->isReadOnly() || self::propertyHasSetter($methods, $propertyName)) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(
                sprintf(
                    'The %s class has an uninitialized readonly property $%s. Assign it in the constructor or method.',
                    $classReflection->getDisplayName(),
                    $propertyName,
                ),
            )
                ->line($propertyNode->getLine())
                ->build();
        }

        foreach ($prematureAccess as [$propertyName, $line, $propertyNode, $file, $fileDescription]) {
            if (!$propertyNode->isReadOnly()) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(sprintf('Access to an uninitialized readonly property %s::$%s.', $classReflection->getDisplayName(), $propertyName))
                ->line($line)
                ->file($file, $fileDescription)
                ->build();
        }

        foreach ($additionalAssigns as [$propertyName, $line, $propertyNode]) {
            if (!$propertyNode->isReadOnly()) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(sprintf('Readonly property %s::$%s is already assigned.', $classReflection->getDisplayName(), $propertyName))
                ->line($line)
                ->build();
        }

        return $errors;
    }

    /**
     * @param array<ClassMethod> $methods
     */
    private static function propertyHasSetter(array $methods, string $propertyName): bool
    {
        foreach ($methods as $method) {
            $smtms = $method->getStmts();

            if (!$smtms || count($smtms) > 1 || !$smtms[0] instanceof Node\Stmt\Expression) {
                continue;
            }

            $expr = $smtms[0]->expr;

            if (!$expr instanceof Node\Expr\Assign) {
                continue;
            }

            if (!$expr->var instanceof Node\Expr\PropertyFetch || !$expr->var->name instanceof Node\Identifier) {
                continue;
            }

            if ($expr->var->name->name !== $propertyName) {
                continue;
            }

            return true;
        }

        return false;
    }
}
