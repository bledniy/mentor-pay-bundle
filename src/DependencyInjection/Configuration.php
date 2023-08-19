<?php

namespace AppPaymentClient\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('app_payment_client');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->variableNode('service_name')->end()
                ->variableNode('webhook_route')->end()
                ->variableNode('checkout_webhook_route')->end()
//                ->variableNode('order_url')->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
