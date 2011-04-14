<?php

namespace Sweet\ScaffoldBundle\Tests\Command;
/**
 * @see FOS/UserBundle/Tests/Command/CreateUserCommandTest
 */
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sweet\ScaffoldBundle\Command\GenerateWebTestCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;

class GenerateWebTestCommandTest extends WebTestCase
{
    public function testGenerateWebTestCommand ()
    {
        $kernel = $this->createKernel();
        $command = new GenerateWebTestCommand();
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
