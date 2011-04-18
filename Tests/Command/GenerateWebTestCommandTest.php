<?php

namespace Sweet\ScaffoldBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sweet\ScaffoldBundle\Command\GenerateWebTestCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;

class GenerateWebTestCommandTest extends WebTestCase
{
    public function testGenerateWebTestFullCommand ()
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
        $fullpath = 'src/Sweet/ScaffoldBundle/Tests/Controller/indexControllerTest.php';
        $this->assertFileExists($fullpath);
        
        $content = fread(fopen($fullpath, 'r'), filesize($fullpath));
        $this->assertContains('namespace Sweet\\ScaffoldBundle\\Tests\\Controller;', $content);
        $this->assertContains('class indexControllerTest extends WebTestCase', $content);

        unlink('src/Sweet/ScaffoldBundle/Tests/Controller/indexControllerTest.php');
        rmdir('src/Sweet/ScaffoldBundle/Tests/Controller');
    }

    public function testGenerateWebTestCommand ()
    {
        $kernel = $this->createKernel();
        $command = new GenerateWebTestCommand();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $tester = new ApplicationTester($application);

        $bundle     = 'Sweet\\ScaffoldBundle';
        $filename   = 'indexControllerTest';

        $tester->run(array(
            'command'   => $command->getFullName(),
            'bundle'    => $bundle,
            'filename'  => $filename,
        ));

        $this->assertRegExp('/\[File\+\]/', $tester->getDisplay());
        $fullpath = 'src/Sweet/ScaffoldBundle/Tests/indexControllerTest.php';
        $this->assertFileExists($fullpath);
        
        $content = fread(fopen($fullpath, 'r'), filesize($fullpath));
        $this->assertContains('namespace Sweet\\ScaffoldBundle\\Tests;', $content);
        $this->assertContains('class indexControllerTest extends WebTestCase', $content);
        
        unlink('src/Sweet/ScaffoldBundle/Tests/indexControllerTest.php');
    }
}
