<?php
/**
 * @name implodeAssoc($glue,$arr)
 * @description makes a string from an assiciative array
 * @parameter glue: the string to glue the parts of the array with
 * @parameter arr: array to implode
 */
function implodeAssoc($glue,$arr)
{
    $keys=array_keys($arr);
    $values=array_values($arr);

    return(implode($glue,$keys).$glue.implode($glue,$values));
};

/**
 * @name explodeAssoc($glue,$arr)
 * @description makes an assiciative array from a string
 * @parameter glue: the string to glue the parts of the array with
 * @parameter arr: array to explode
 */
function explodeAssoc($glue,$str)
{
    $arr=explode($glue,$str);

    $size=count($arr);

    for ($i=0; $i < $size/2; $i++)
        $out[$arr[$i]]=$arr[$i+($size/2)];

    return($out);
}; 