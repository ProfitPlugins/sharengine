<?php
    function number_to_hour($number)
    {
        $next_number = $number+1;
        if($next_number>23)
        {
            $next_number = 0;
        }

        if($number <10)
            $number = "0".$number;
        if($next_number<10)
            $next_number = "0".$next_number;

        return "$number:00 - $next_number:00";
    }
    function load_view($view, $data=array())
    {

        ob_start();
        extract($data);
        include 'views/'.$view.'.php';
        $content=ob_get_clean();

        return $content;
    }

    function sluggify($text)
    {
        $text = preg_replace('~[^\\pL\d./]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        //$text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w./]+~', '', $text);

        if (empty($text))
        {
            return '';
        }

        return $text;
    }
    function get_random_with_weight(array $weightedValues) {
        $rand = mt_rand(1, (int) array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }
    function get_sequential_with_weight(array $weightedValues, $number)
    {
        // if we have only 1 link in the array
        if(count($weightedValues) == 1)
        {
            // we need to return the key of the first element of the array.
             reset($weightedValues);
             key($weightedValues);
        }


        $first = true;

        $new_array = array();
        foreach($weightedValues as $k=>$value)
        {
            if($first == false)
            {
                $new_array[$k] = $value + $new_array[$lastKey];
            }
            if($first == true)
            {

                $new_array[$k] = $value;
                $first = false;
            }
            $lastKey = $k;

        }
        foreach($new_array as $k=>$v)
        {
            if($number <=$v)
                return $k;
        }



    }
