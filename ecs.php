<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $parameters->set(
        'skip',
        [
            BlankLineAfterOpeningTagFixer::class,
            LinebreakAfterOpeningTagFixer::class,
        ]
    );

    $containerConfigurator->import(SetList::SPACES);
    $containerConfigurator->import(SetList::PSR_12);

//    $parameters->set(Option::SETS, [
//        SetList::SPACES,
//        //SetList::ARRAY,
//        //SetList::DOCBLOCK,
//        //SetList::NAMESPACES,
//        //SetList::CONTROL_STRUCTURES,
//        //SetList::CLEAN_CODE,
//        SetList::PSR_12,
//    ]);


    $services = $containerConfigurator->services();

    $services->set(DeclareStrictTypesFixer::class);
    //$services->set(LinebreakAfterOpeningTagFixer::class);

    $services->set(BlankLineAfterNamespaceFixer::class);

    $services->set(NoUnusedImportsFixer::class);

    $services->set(StrictComparisonFixer::class);


    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    // run and fix, one by one
    $containerConfigurator->import(SetList::SPACES);
    // $containerConfigurator->import(SetList::ARRAY);
    // $containerConfigurator->import(SetList::DOCBLOCK);
    $containerConfigurator->import(SetList::PSR_12);
};
