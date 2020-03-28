<?php

use Illuminate\Support\Arr;

function add_html_snipet (String $string, $opening_tag='', $closing_tag='', $position ='all', $glue=' ') {
    $wordArray = explode(' ', $string);

    switch ($position) {
        case 'all': 
            for($i=0;$i<count($wordArray);$i++) {
                Arr::set($wordArray, $i, $opening_tag.$wordArray[$i].$closing_tag);
            }
            break;
        case 'even':
            $i = 1;
            while ($i < count($wordArray)) {
                Arr::set($wordArray, $i, $opening_tag.$wordArray[$i].$closing_tag);
                $i = $i+2;
            }
            break;
        case 'odd':
            $i = 0;
            while ($i < count($wordArray)) {
                for($i=0;$i<count($wordArray);$i++) {
                    if (!($i % 2)) {
                        Arr::set($wordArray, $i, $opening_tag.$wordArray[$i].$closing_tag);
                    }
                }
            }
            break;
    }

    return implode($glue, $wordArray);
}