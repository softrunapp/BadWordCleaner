<?php

class BadWordCleaner {
  
  //evey where find this -> is filtering
  private $filterList1 = ["xx"];
  //every word is equals this -> is filtering
  private $filterList2 = ["bad"];
  
  public static function isFilterText($text)
    {
        $text = strtolower($text);
        foreach ($this->filterList1 as $item) {
            if (strpos($text, $item) !== false) {
                return true;
            }
        }

        // change arabic characters to persion
        $text = str_replace("  ", "", $text);
        $text = str_replace("ي", "ی", $text);
        $text = str_replace("ك", "ک", $text);
        $text = str_replace("آ", "ا", $text);
        $text = str_replace("ئ", "ی", $text);
        
        $text = str_replace(str_split('\\/:*?"<>|0123456789`~!@#$%^&*()_+-=\|/-?><,.'), '', $text);
        $array = explode(" ", $text);

        $finalText = "";
        foreach ($array as $value) {
            $clearValue = "";
            $lastChar = "";
            $value = mb_substr($value, 0);
            for ($i = 0; $i < mb_strlen($value); $i++) {
                $char = mb_substr($value, $i, 1);
                if (strcmp($char, $lastChar) != 0) {
                    $clearValue .= $char;
                    $lastChar = $char;
                }
            }
            foreach ($this->filterList1 as $item) {
                if (strpos($clearValue, $item) !== false) {
                    return true;
                }
            }
            $finalText .= $clearValue;
            if (in_array($clearValue, $this->filterList2)) {
                return true;
            }
        }

        foreach ($this->filterList1 as $item) {
            if (strpos($finalText, $item) !== false) {
                return true;
            }
        }
        if (in_array($finalText, $this->filterList2)) {
            return true;
        }
        return false;
    }
}
