<?php


namespace Bin\Components;


class Animation
{
    public static function show(): void
    {
        foreach (range(1, 180) as $i) {
            echo '+';
            usleep(5000);
        }
        echo "\n";
    }
}