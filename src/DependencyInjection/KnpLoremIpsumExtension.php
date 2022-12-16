<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpLoremIpsumExtension extends Extension
{

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__. '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        $definition = $container->getDefinition('knp_u_lorem_ipsum.knp_uipsum');

        if (null !== $config['word_provider']) {
            $container->setAlias('knp_u_lorem_ipsum.knpu_word_provider', $config['word_provider']);
        }
        $definition->setArgument(1, $config['unicorns_are_real'])
            ->setArgument(2, $config['min_sunshine']);
    }

}