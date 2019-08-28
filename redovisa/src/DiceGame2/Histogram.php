<?php

namespace Anax\DiceGame2;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $nrArr = $this->serie;
        $strPrint = "";
        $length = count($this->serie);
        $assoArr = ["1" => "", "2" => "", "3" => "", "4" => "", "5" => "", "6" => ""];

        # Add the stars to the right place
        for ($i=0; $i < $length; $i++) {
            $strNr = strval($nrArr[$i]);
            $assoArr[$strNr] .= "*";
        }

        # Print all
        $start = $this->min;
        $stop = $this->max + 1;

        for ($i=$start; $i < $stop; $i++) {
            $strPrint .= $i  . " : " . $assoArr[$i] . "</br>";
        }

        return $strPrint;
    }


        /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
