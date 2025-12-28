<?php

namespace Infrastructure\CodeStyle\CodingStandard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Fixer;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\AnnotationHelper;

final class AbstractOrFinalSniff implements Sniff
{
    /** @var array<int> */
    private array $tokens = [
        T_ABSTRACT,
        T_FINAL,
    ];

    private ?Fixer $fixer = null;

    private int $position;

    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $file = $phpcsFile;
        $position = $stackPtr;

        $this->fixer = $phpcsFile->fixer;
        $this->position = $position;
        $finalAnnotations = AnnotationHelper::getAnnotations($file, $position, '@final');

        if (!empty($finalAnnotations) || $file->findPrevious($this->tokens, $position)) {
            return;
        }

        $file->addFixableError(
            'All classes should be declared using either the "abstract" or "final" keyword',
            $position - 1,
            self::class,
        );
    }
}
