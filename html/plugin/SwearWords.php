<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 17:48
 */

class SwearWords extends dataPlugin {

    private $words = array("fuck", "shit");

    public function index($args)
    {
        foreach($args as $key => $value)
        {
            if(in_array($value, $this->words)){
                $args[$key] = get_stars($value);
            }
        }
        return $args;
    }

    private function get_stars($word){
        $newWord = "";
        for($n = 0; $n < strlen($word); $n++ ){
            $newWord = $newWord .  "*";
        }
    }
}