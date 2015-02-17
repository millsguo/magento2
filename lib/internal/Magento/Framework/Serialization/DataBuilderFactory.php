<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\Serialization;

use Magento\Framework\ObjectManagerInterface;

/**
 * Factory used to construct Data Builder based on interface name
 */
class DataBuilderFactory
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Returns a builder for a given class name.
     *
     * @param string $className
     * @return \Magento\Framework\Api\BuilderInterface Builder Instance
     */
    public function getDataBuilder($className)
    {
        $builderClassName = $this->getBuilderClassName($className);
        return $this->createObject($builderClassName);
    }

    /**
     * Returns builder class name
     *
     * @param string $className
     * @return string
     */
    protected function getBuilderClassName($className)
    {
        $interfaceSuffix = 'Interface';
        if (substr($className, -strlen($interfaceSuffix)) === $interfaceSuffix) {
            /** If class name ends with Interface, replace it with Data suffix */
            $builderClassName = substr($className, 0, -strlen($interfaceSuffix)) . 'Data';
        } else {
            $builderClassName = $className;
        }
        $builderClassName .= 'Builder';

        $builderClassName = ltrim($builderClassName, '\\');
        return $builderClassName;
    }

    /**
     * Creates builder object
     *
     * @param string $builderClassName
     * @return \Magento\Framework\Api\BuilderInterface Builder Instance
     */
    protected function createObject($builderClassName)
    {
        return $this->objectManager->create($builderClassName);
    }
}
