<?php

namespace Sweet\ScaffoldBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sweet\ScaffoldBundle\Command\GenerateUnitTestCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;

class GenerateUnitTestCommandTest extends WebTestCase
{
    public function testGenerateUnitTestCommand ()
    {
        $kernel = $this->createKernel();
        $command = new GenerateUnitTestCommand();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $tester = new ApplicationTester($application);

        $bundle     = 'Sweet\\ScaffoldBundle';
        $filename   = 'indexControllerTest';
        $path       = 'Controller';

        $tester->run(array(
            'command'   => $command->getFullName(),
            'bundle'    => $bundle,
            'filename'  => $filename,
            'path'      => $path,
        ));

        $this->assertRegExp('/\[File\+\]/', $tester->getDisplay());
        $this->assertFileExists('src/Sweet/ScaffoldBundle/Tests/Controller/indexControllerTest.php');
    }

    protected function tearDown ()
    {
        unlink('src/Sweet/ScaffoldBundle/Tests/Controller/indexControllerTest.php');
        rmdir('src/Sweet/ScaffoldBundle/Tests/Controller');
    }
}