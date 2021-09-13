<?php

declare(strict_types = 1);

use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    /* Define the PHP version
     * https://github.com/rectorphp/rector#provide-php-version
     */
    $parameters->set(Option::PHP_VERSION_FEATURES, '7.4');

    $services = $containerConfigurator->services();

    // List of rules that will be applied without asking confirmation of the user
    // Full list is here : https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md
    $services->set(RemoveUnusedForeachKeyRector::class);
    $services->set(RemoveUnusedPrivateMethodParameterRector::class);
    $services->set(RemoveUnusedVariableAssignRector::class);
    $services->set(RemoveUselessParamTagRector::class);
    $services->set(RemoveCodeAfterReturnRector::class);
    $services->set(RemoveUselessReturnTagRector::class);
    $services->set(RemoveNullPropertyInitializationRector::class);
    $services->set(FlipTypeControlToUseExclusiveTypeRector::class);
    $services->set(MoveVariableDeclarationNearReferenceRector::class);
    $services->set(CountArrayToEmptyArrayComparisonRector::class);
    $services->set(RecastingRemovalRector::class);
    $services->set(SimplifyUselessVariableRector::class);

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

    /* Don't auto import names
     * https://github.com/rectorphp/rector#import-use-statements
     */
    $parameters->set(Option::AUTO_IMPORT_NAMES, false);

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
            getcwd() . '/.cache/*',
            getcwd() . '/.config/*',
            getcwd() . '/.githooks/*',
            getcwd() . '/.install/*',
            getcwd() . '/.output/*',
            getcwd() . '/.tools/*',
            getcwd() . '/.vscode/*',
            getcwd() . '/node_modules/*',
            getcwd() . '/vendor/*',
        ]
    );
};
