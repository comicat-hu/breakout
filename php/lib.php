<?php
/**
 * PHP version 5.6.31
 * PHP some useful function
 *
 * @category None
 * @package  None
 * @author   comi.hu <comi.hu@104.com.tw>
 * @license  PHP License
 * @link     None
 */


/**
 * Return convert special chars and more spaces
 * 
 * @param string $data input
 * 
 * @return string
 */
function convertInput($data) 
{
    $data = trim($data); // Remove more space
    $data = stripcslashes($data); // Remove "\"
    $data = htmlspecialchars($data); // HTML special chars encode
    return $data;
}