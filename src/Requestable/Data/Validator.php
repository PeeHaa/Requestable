<?php
/**
 * Parses the data of the request to create an object containing all the info to fire requests to services
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable\Data;

/**
 * Parses the data of the request to create an object containing all the info to fire requests to services
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Validator
{
    /**
     * @var \Requestable\Data\Request The request data to be validated
     */
    private $request;

    /**
     * @var array List of errors
     */
    private $errors = [];

    /**
     * Creates instance
     *
     * @param \Requestable\Data\Request $request The request data to be validated
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Check whether the request data is valid
     *
     * @return boolean True when the request data is valid
     */
    public function isValid()
    {
        $this->validate();

        return count($this->errors) === 0;
    }

    /**
     * Validates the request data
     */
    private function validate()
    {
        if (!$this->request->getUri()) {
            $this->errors[] = 'uri.required';
        }

        if (!$this->request->getMethod()) {
            $this->errors[] = 'method.required';
        }
    }

    /**
     * Gets the errors
     *
     * @return array The errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
