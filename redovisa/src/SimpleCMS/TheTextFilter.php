<?php
/**
 *  BlogView
 *  php version 7
 *
 * @category SimpleCMS
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

namespace Anax\SimpleCMS;

use \Michelf\Markdown as Markdown;

// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore
// phpcs:disable PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore

/**
 * Filter and format text content.
 *
 * Links
 * https://dbwebb.se/coachen/typografiska-element-med-smartypants
 * http://htmlpurifier.org/
 * https://stackoverflow.com/questions/294355/php-yaml-parsers/3691710#3691710
 * https://michelf.ca/projects/php-smartypants/
 * https://daringfireball.net/projects/markdown/
 *
 * @category SimpleCMS
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/
class TheTextFilter implements TheTextFilterInterface
{
    /**
     * Filters
     *
     * @var array $filters Supported filters with method names of
     *                     their respective handler.
     */
    private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
    ];


    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text      The text to filter.
     * @param array  $filterArr Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filterArr)
    {
        // Intersection means keys present in both arrays will remain

        // Array flip of the filter array means it does not need to be
        // an associative array.
        $chosenFilter=array_intersect_key($this->filters, array_flip($filterArr));

        foreach ($chosenFilter as $filter => $action) {
            if (!$filter) {
                return;
            }
            // var_dump($action);
            switch ($action) {
                case ("bbcode2html"):
                    $text = $this->bbcode2html($text);
                    // var_dump($filteredTxt);
                    break;
                case ("makeClickable"):
                    $text = $this->makeClickable($text);
                    // var_dump($filteredTxt);
                    break;
                case ("markdown"):
                    $text = $this->markdown($text);
                    break;
                case ("nl2br"):
                    $text = $this->nl2brFilter($text);
                    break;
                // default:
                //     var_dump('default');
                //     $text = $text;
            }
        }

        return $text;
    }



    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    private function bbcode2html($text)
    {
            $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
            ];

            $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
            ];
            return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {

        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()
            <>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\"{$matches[0]}\">
                {$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     */
    public function markdown($text)
    {
        $markdown = new Markdown();
        // return Markdown::defaultTransform($text);

        return $markdown->defaultTransform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     * The \n needs to be in "" and not ''
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2brFilter($text)
    {
         // Can be advanced to hold xhtml w the true boolean, check manual
        return nl2br($text, false);
    }


    /**
     * SLugify by Mos
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }




    /**
     * Db filter
     * Coma seperated list from array
     * Get the filter post data coma seperated from post
     *
     * @param array $theArr : the filter values
     *
     * @return string $filterString : the filter values
     */
    public function dbFilter($theArr)
    {
        $theString = "";
        foreach ($theArr as $key => $value) {
            if (!$key) {
                return;
            }
            if (!is_numeric($value) && isset($value)) {
                $theString .= "$value,";
            }
        }
        $theString = rtrim($theString, ","); // remove last coma

        return $theString;
    }
}
