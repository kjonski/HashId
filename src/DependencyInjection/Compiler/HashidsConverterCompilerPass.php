<?php

namespace Pgs\HashIdBundle\DependencyInjection\Compiler;

use Hashids\Hashids;
use Pgs\HashIdBundle\ParametersProcessor\Converter\HashidsConverter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class HashidsConverterCompilerPass extends AbstractConverterCompilerPass
{
    protected function registerService(ContainerBuilder $container): void
    {
        $serviceDefinition = new Definition(
            Hashids::class,
            [
                $container->getParameter(
                    sprintf('pgs_hash_id.converter.%s.salt', $this->getConverterName())
                ),
                $container->getParameter(
                    sprintf('pgs_hash_id.converter.%s.min_hash_length', $this->getConverterName())
                ),
                $container->getParameter(
                    sprintf('pgs_hash_id.converter.%s.alphabet', $this->getConverterName())
                ),
            ]
        );
        $serviceDefinition->setPublic(false);

        $container->addDefinitions([sprintf('pgs_hash_id.%s', $this->getConverterName()) => $serviceDefinition]);
    }

    protected function getSupportedClass(): string
    {
        return Hashids::class;
    }

    protected function getConverterClass(): string
    {
        return HashidsConverter::class;
    }

    protected function getConverterName(): string
    {
        return 'hashids';
    }
}
