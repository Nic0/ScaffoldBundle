A simple bundle, learning purpose. Generate some files.

So far:

- scaffold:webtest
- scaffold:unittest

-------------------------------------------

Installation
============

Add the bundle in vendor/bundles/ directory
-------------------------------------------

::

    git submodule add git://github.com/Nic0/ScaffoldBundle.git
    vendor/bundle/Sweet/ScaffoldBundle

Add the Sweet namespace to your autoloader
------------------------------------------

::

    // app/autoload.php
    $loader->registerNamespaces(array(
        'Sweet'  => __DIR__.'/../vendor/bundles',
        // your other namespaces
    );

Add ScaffoldBundle to your application kernel
---------------------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new Sweet\ScaffoldBundle\SweetScaffoldBundle(),
            // ...
        );
    }


