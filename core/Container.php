<?php

namespace core;

use core\Exceptions\ContainerException;
use core\Exceptions\ParameterNotFoundException;
use core\Exceptions\ServiceNotFoundException;
use core\Reference\ParameterReference;
use core\Reference\ServiceReference;

class Container implements ContainerInterface
{
    private $services;
    private $parameters;
    private $serviceStore;

    /**
     * All we are doing here is implementing the ContainerInterface from container-interop and 
     * loading the definitions into properties that can be accessed later. We have also created 
     * a serviceStore property, and initialized it to be an empty array. 
     * When the container is asked to create services, we will save these in this array 
     * so that they can be retrieved later without having to recreate them.
     */
    public function __construct(array $services = [], array $parameters = [])
    {
        $this->services     = $services;
        $this->parameters   = $parameters;
        $this->serviceStore = [];
    }

    /**
     * This method simply checks to see if the container has the definition for a service. 
     * If it does not, the ServiceNotFoundException that we created earlier is thrown. 
     * If it does, it returns the service, creating it and saving it to the store if it has not already done so.
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new ServiceNotFoundException('Service not found: '.$name);
        }

        if (!isset($this->serviceStore[$name])) {
            $this->serviceStore[$name] = $this->createService($name);
        }

        return $this->serviceStore[$name];
    }

    /**
     * Method for retrieving a parameter from the container. 
     * Assuming the parameters passed to the constructor form an N-dimensional associative array, 
     * we need some way of cleanly accessing any element within that array using a single string. 
     * An easy way of doing this is to use . as a delimiter, so that the string foo.bar refers to 
     * the bar key in the foo key of the root parameters array.
     */
    public function getParameter($name)
    {
        $tokens  = explode('.', $name);
        $context = $this->parameters;

        while (null !== ($token = array_shift($tokens))) {
            if (!isset($context[$token])) {
                throw new ParameterNotFoundException('Parameter not found: '.$name);
            }

            $context = $context[$token];
        }

        return $context;
    }

    /**
     * This is a pretty simple method, and it just needs to check if the definitions array 
     * provided to the constructor contains an entry for the $name service.
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    /**
     *  This method will use the definitions provided to create the service. 
     *  As we do not want this method to be called from outside the container, we shall make it private.
     *  The first thing to do in this method is some sanity checks. For each service definition we 
     *  require an array containing a class key and optional arguments and calls keys. These will be used 
     *  for constructor injection and setter injection respectively. We can also add protection against 
     *  circular references by checking to see if we have already attempted to create the service.
     * 
     * If the arguments key exists, we want to convert that array of argument definitions into an array of PHP values 
     * that can be passed to the constructor. To do this, we will need to convert the reference objects that we defined earlier 
     * to the values that they reference in from the container. 
     * For now, we will take this logic into the resolveArguments($name, array $argumentDefinitons) method. 
     * We use the ReflectionClass::newInstanceArgs() method to create the service using the arguments array. 
     * This is the constructor injection.
     * 
     * If the calls key exists, we want to use the array of call definitions and apply them 
     * to the service that we have just created. Again, we will take this logic into a separate method defined 
     * as initializeService($service, $name, array $callDefinitions). 
     * This is the setter injection.
     */
    private function createService($name)
    {
        $entry = &$this->services[$name];

        if (!is_array($entry) || !isset($entry['class'])) {
            throw new ContainerException($name.' service entry must be an array containing a \'class\' key');
        } elseif (!class_exists($entry['class'])) {
            throw new ContainerException($name.' service class does not exist: '.$entry['class']);
        } elseif (isset($entry['lock'])) {
            throw new ContainerException($name.' service contains a circular reference');
        }

        $entry['lock'] = true;

        $arguments = isset($entry['arguments']) ? $this->resolveArguments($name, $entry['arguments']) : [];

        $reflector = new \ReflectionClass($entry['class']);
        $service = $reflector->newInstanceArgs($arguments);

        if (isset($entry['calls'])) {
            $this->initializeService($service, $name, $entry['calls']);
        }

        return $service;
    }


    /**
     * This will convert an array of argument definitions into an array of PHP values. 
     * To do this it will need to replace ParameterReference and ServiceReference objects 
     * with the appropriate parameters and services from the container.
     */
    private function resolveArguments($name, array $argumentDefinitions)
    {
        $arguments = [];

        foreach ($argumentDefinitions as $argumentDefinition) {
            if ($argumentDefinition instanceof ServiceReference) {
                $argumentServiceName = $argumentDefinition->getName();

                $arguments[] = $this->get($argumentServiceName);
            } elseif ($argumentDefinition instanceof ParameterReference) {
                $argumentParameterName = $argumentDefinition->getName();

                $arguments[] = $this->getParameter($argumentParameterName);
            } else {
                $arguments[] = $argumentDefinition;
            }
        }

        return $arguments;
    }


    /**
     * This method performs the setter injection on the instantiated service object. 
     * To do this it needs to loop through an array of method call definitions. 
     * The method key is used to specify the method, 
     * and an optional arguments key can be used to provide arguments to that method call. 
     * We can reuse the method we just wrote to translate those arguments into PHP values.
     */
    private function initializeService($service, $name, array $callDefinitions)
    {
        foreach ($callDefinitions as $callDefinition) {
            if (!is_array($callDefinition) || !isset($callDefinition['method'])) {
                throw new ContainerException($name.' service calls must be arrays containing a \'method\' key');
            } elseif (!is_callable([$service, $callDefinition['method']])) {
                throw new ContainerException($name.' service asks for call to uncallable method: '.$callDefinition['method']);
            }

            $arguments = isset($callDefinition['arguments']) ? $this->resolveArguments($name, $callDefinition['arguments']) : [];

            call_user_func_array([$service, $callDefinition['method']], $arguments);
        }
    }
}
