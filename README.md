# Symfony-Smarty standalone forms
Implementation of Symfony2 forms component with smarty templates

The 'views/Form' directory contains a bootstrap implementation (horizontal) of the symfony2 bootstrap created in Twig (https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/bootstrap_3_layout.html.twig & https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/bootstrap_3_horizontal_layout.html.twig)

web/index.php contains a 'demo' controller to pull together the various components, create a Smarty instance and then output it.

There's also a plain php form rendering option also if smarty isn't your thing.