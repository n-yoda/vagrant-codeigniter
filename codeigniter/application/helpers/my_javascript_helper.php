<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('script_tag'))
{
    function script_tag($file = '')
    {
        return '<script type="text/javascript" src="' . $file . '"></script>';
    }
}

if ( ! function_exists('script_tag_jquery'))
{
    function script_tag_jquery()
    {
        return script_tag(base_url('js/jquery.js'));
    }
}