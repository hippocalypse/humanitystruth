<?php namespace App\Services;

use HTMLPurifier, HTMLPurifier_Config;

class Purifier  {

    public static function clean($html)
    {
        require base_path('vendor/ezyang/htmlpurifier/library/') . 'HTMLPurifier.auto.php';
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray([
            'Core.Encoding' => 'UTF-8',
            'HTML.Doctype' => 'XHTML 1.0 Strict',
            'HTML.Allowed' => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty' => true
        ]);
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }

}