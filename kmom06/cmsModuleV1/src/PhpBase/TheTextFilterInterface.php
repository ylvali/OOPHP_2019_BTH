<?php
/**
 *  TheTextFilterInterface
 *  php version 7
 *
 * @category TheTextFilterInterface
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\PhpBase;
use PDO;
use Exception;

/**
 *  TheTextFilterInterface
 *  the interface for the TheTextFilter.
 *
 *  Php version 7
 *
 * @category CmsPrintModuleInterface
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

interface TheTextFilterInterface
{
    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filterArr Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filterArr);

}
