<?php declare(strict_types=1);

namespace App\Command;

use App\Tests\AbstractTestRunner;
use App\Tests\ArraySearchVsFor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PerformanceTestCommand extends Command
{
    protected static $defaultName = 'app:performance-test';

    protected function configure()
    {
        $this->setDescription('Performance test');
    }

    /**
     * @return array|AbstractTestRunner[]
     */
    private function getTests(): array
    {
        // You can add/enable tests here.
        return [
            // new ArrayKeyExistsVsIsset(),
            // new ArraySearchVsIsset(),
            // new SnakeCaseToCamelCaseTest(),
            // new ArrayMergeVsArrayPlusArray(),
            new ArraySearchVsFor(),
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rightAligned = new TableStyle();
        $rightAligned->setPadType(STR_PAD_LEFT);

        $table = (new Table($output))
            ->setColumnStyle(1, $rightAligned)
            ->setColumnStyle(2, $rightAligned)
            ->setColumnStyle(3, $rightAligned);

        $headers = [];

        $tests = $this->getTests();

        foreach ($tests as $test) {
            $test->runTests();
            $result = $test->getResult();

            if (empty($headers)) {
                $headers = array_keys($result[0]);
            }

            // Sort fastest to slowest.
            usort($result, function (array $rowA, array $rowB) {
                return intval(preg_replace('~[^0-9]+~', '', $rowB['# iterations'])) <=> intval(preg_replace('~[^0-9]+~', '', $rowA['# iterations']));
            });

            $table->addRows($result);
        }

        $table
            ->setHeaders($headers)
            ->render();

        return 0;
    }
}
