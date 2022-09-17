<?php declare(strict_types=1);

namespace App\Command;

use App\Tests\AbstractTestRunner;
use App\Tests\ArrayFillVsForLoop;
use App\Tests\ArraySearchVsFor;
use App\Tests\PowVsAsterisks;
use App\Tests\SerializeVsJsonEncode;
use App\Tests\UnserializeVsJsonDecode;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PerformanceTestCommand extends Command
{
    protected static $defaultName = 'app:performance-test';

    private OutputInterface $output;

    protected function configure()
    {
        $this->setDescription('Performance test');
    }

    /**
     * @return array|AbstractTestRunner[]
     */
    private function getTests(): array
    {
        // TODO: add test selector

        // You can add/enable tests here.
        return [
            // new ArrayKeyExistsVsIsset(),
            // new ArraySearchVsIsset(),
            // new SnakeCaseToCamelCaseTest(),
            // new ArrayMergeVsArrayPlusArray(),
            // new ArraySearchVsFor(),
            // new ArrayFillVsForLoop(),
            new SerializeVsJsonEncode(),
            new UnserializeVsJsonDecode(),
            // new PowVsAsterisks(),
        ];
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tests = $this->getTests();

        foreach ($tests as $test) {
            $test->runTests();

            $result = $test->getResult();

            $headers = array_keys($result[0]);

            // Sort fastest to slowest.
            usort($result, function (array $rowA, array $rowB) {
                return intval(preg_replace('~[^0-9]+~', '', $rowB['# iterations'])) <=> intval(preg_replace('~[^0-9]+~', '', $rowA['# iterations']));
            });

            $this->outputTable($test->getName(), $headers, $result);
        }

        return 0;
    }

    private function outputTable(string $testName, array $headers, array $result): void
    {
        $rightAligned = new TableStyle();
        $rightAligned->setPadType(STR_PAD_LEFT);

        $table = (new Table($this->output))
            ->setStyle('box')
            ->setColumnStyle(1, $rightAligned)
            ->setColumnStyle(2, $rightAligned)
            ->setColumnStyle(3, $rightAligned)
            ->setColumnStyle(4, $rightAligned);

        $table
            ->setHeaderTitle($testName)
            ->setHeaders($headers)
            ->addRows($result)
            ->render();
    }
}
