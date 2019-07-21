<?php

if (! function_exists('voter_password')) {
    /**
     * Generate a specific character for password
     *
     * @param  int  $length
     * @return string
     *
     * @throws \RuntimeException
     */
    function voter_password($length = 6)
    {
        return substr(str_shuffle(str_repeat($x='234678wertypsdfghjkzxcbnm', ceil($length/strlen($x)) )),1,$length);
    }
}

if (! function_exists('vote_percentage')) {
    /**
     * Generate a specific character for password
     *
     * @param  int  $length
     * @return string
     *
     * @throws \RuntimeException
     */
    function vote_percentage($x, $y)
    {   
        if($y !== 0){
            $a = ($x / $y) * 100;
            return round(abs($a));
        }else{
            return "0";
        }
    }
}