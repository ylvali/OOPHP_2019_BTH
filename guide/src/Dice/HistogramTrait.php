<?php

namespace Ylva\Dice;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram(int $min = null, int $max = null)
    {
      $nrArr = $this->serie;
      $strPrint = "";
      $length = count($this->serie);
      $assoArr = ["1" => "", "2" => "", "3" => "", "4" => "", "5" => "", "6" => ""];
      $printAll = False;


      # Add the stars to the right place
      for($i=0; $i < $length; $i++) {
        $strNr = strval($nrArr[$i]);
        $assoArr[$strNr] .= "*";
      }

      # Catch arguments if any
      if($min){
        $start = $min;
        $printAll = True;
      } else {
        $start = 1;
      }

      if($max){
        $stop = $max + 1;
        $printAll = True;
      } else {
        $stop = 7;
      }

      # Create a string print
      for($i=$start; $i < $stop; $i++) {
        if ($printAll) {
          $strPrint .= $i  . " : " . $assoArr[$i] . "</br>";
        } else if($assoArr[$i]) {
          $strPrint .= $i  . " : " . $assoArr[$i] . "</br>";
        }
      }


      return $strPrint;

    }
}
