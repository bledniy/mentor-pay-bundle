<?php

namespace AppPaymentClient\DependencyInjection;

use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\ServiceUrlsProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AppPaymentClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $serviceNameProvider = new Definition(ServiceNameProvider::class);
        $serviceNameProvider->addArgument($config['service_name'] ?? '');
        $container->setDefinition(ServiceNameProvider::class, $serviceNameProvider);

        $serviceUrlsProvider = new Definition(ServiceUrlsProvider::class);
        $serviceUrlsProvider
            ->addArgument($config['webhook_route'] ?? '')
            ->addArgument($config['checkout_webhook_route'] ?? '')
//            ->addArgument($config['order_url'] ?? '')
        ;
        $container->setDefinition(ServiceUrlsProvider::class, $serviceUrlsProvider);
    }
}
