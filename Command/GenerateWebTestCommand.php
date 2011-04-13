<?php

/**
 * (c) 2011 Nicolas Paris <nicolas.caen@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sweet\ScaffoldBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;

class GenerateWebTestCommand extends Command
{
    protected function configure () 
    {
        $this
            ->setName('scaffold:webtest')
            ->setDescription('scaffold a WebTestCase file')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'The bundle'),
                new InputArgument('filename', InputArgument::REQUIRED, 'The name of the file'),
                new InputArgument('path', InputArgument::OPTIONAL, 'The path inside the Tests directory'),
            ))
            ->setHelp(<<<EOT
The <info>scaffold:webtest</info> command create a WebTestCase file.

    <info>scaffold:webtest "vendor\MyBundle" DemoControlleTest Controller</info>
    It will create a webtest file in src/vendor/MyBundle/Tests/Controller/DemoControllerTest.php
EOT
        );
    }

    protected function execute (InputInterface $input, OutputInterface $output) 
    {
        $bundle     = $input->getArgument('bundle');
        $filename   = $input->getArgument('filename');
        $path       = $input->getArgument('path');
        $namespace  = $bundle.'\\Tests\\'.$path;
        $targetFile = 'src/'.strtr($bundle, '\\', '/').'/Tests/'.$path.'/'.$filename.'.php';

        $filesystem = $this->container->get('filesystem');
        $filesystem->copy(__DIR__.'/../Resources/skeleton/WebTestCase.php', $targetFile);

        Mustache::renderFile($targetFile, array(
            'namespace' => $namespace,
            'className' => $filename,
        ));

        $output->writeln('<info>[File+]</info> '.$targetFile);

    }
}
