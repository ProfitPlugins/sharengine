<?php



    add_filter("se_tools", "add_tools");

    function add_tools($tools)
    {
        $tools['instant-rotator']['name'] = "SE Link Rotator";
        $tools['instant-rotator']['description'] = "The best link Rotator ever.";
        $tools['instant-rotator']['version'] = "1.0";

        return $tools;
    }

    $enabled_tools = get_option("se_tools");

    if($enabled_tools['instant-rotator'])
    {
        include 'InstantRotator.php';
    }