<?php
/**
 *    ______            __             __
 *   / ____/___  ____  / /__________  / /
 *  / /   / __ \/ __ \/ __/ ___/ __ \/ /
 * / /___/ /_/ / / / / /_/ /  / /_/ / /
 * \______________/_/\__/_/   \____/_/
 *    /   |  / / /_
 *   / /| | / / __/
 *  / ___ |/ / /_
 * /_/ _|||_/\__/ __     __
 *    / __ \___  / /__  / /____
 *   / / / / _ \/ / _ \/ __/ _ \
 *  / /_/ /  __/ /  __/ /_/  __/
 * /_____/\___/_/\___/\__/\___/
 *
 */

namespace MichielGerritsen\Revive\Validate\Validators;

use MichielGerritsen\Revive\FileSystem\CurrentWorkingDirectory;

class PhpUnitFileExists implements ValidatorContract
{
    /**
     * @var CurrentWorkingDirectory
     */
    private $directory;

    public function __construct(
        CurrentWorkingDirectory $directory
    ) {
        $this->directory = $directory;
    }

    public function shouldContinue(): bool
    {
        return true;
    }

    public function validate(): bool
    {
        $paths = [
            'dev/tests/integration/phpunit.xml',
            'dev/tests/quick-integration/phpunit.xml',
        ];

        foreach ($paths as $path) {
            if (file_exists($this->directory->get() . '/' . $path)) {
                return true;
            }
        }

        return false;
    }

    public function getErrors(): array
    {
        return [
            'The `dev/tests/integration/phpunit.xml` file is missing. See this page on how to prepare to run the ' .
            'integration tests: https://devdocs.magento.com/guides/v2.3/test/integration/integration_test_execution.html'
        ];
    }
}
