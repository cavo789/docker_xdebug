<?php

declare(strict_types = 1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    /* Define the PHP version
     * https://github.com/rectorphp/rector#provide-php-version
     */
    $parameters->set(Option::PHP_VERSION_FEATURES, '7.4');

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        // SetList::CODE_QUALITY,
        SetList::CODE_QUALITY_STRICT,
        // SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        // SetList::MONOLOG_20,
        // SetList::NAMING,
        SetList::ORDER,
        // SetList::PHP_70,
        // SetList::PHP_71,
        // SetList::PHP_72,
        // SetList::PHP_73,
        // SetList::PHP_74,
        // SetList::PSR_4,
        // SetList::SAFE_07,
    ]);

    /* Autoloading
     * https://github.com/rectorphp/rector#extra-autoloading
     */
    if (is_file(getcwd() . '/vendor/autoload.php')) {
        $parameters->set(
            Option::AUTOLOAD_PATHS,
            [
                getcwd() . '/vendor/autoload.php',
            ]
        );
    }

    /* List of paths to scan and refactor
     * https://github.com/rectorphp/rector#paths
     */
    $parameters->set(
        Option::PATHS,
        [
            getcwd() . '/src',
            getcwd() . '/tests',
        ]
    );

    /* Paths Exclusions
     * https://github.com/rectorphp/rector#exclude-paths-and-rectors
     */
    $parameters->set(
        Option::SKIP,
        [
            // Skip folders
            getcwd() . '/.cache/*',
            getcwd() . '/.config/*',
            getcwd() . '/.githooks/*',
            getcwd() . '/.install/*',
            getcwd() . '/.output/*',
            getcwd() . '/.tools/*',
            getcwd() . '/.vscode/*',
            getcwd() . '/node_modules/*',
            getcwd() . '/vendor/*',
            // Exclude rules
            MoveOutMethodCallInsideIfConditionRector::class,
            OrderMethodsByVisibilityRector::class,
            OrderPrivateMethodsByUseRector::class
            RenameFunctionRector::class,
        ]
    );
};
