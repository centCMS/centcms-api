<?php
namespace LightCloud\CentCMS\Api\Plugins;
use Ph\{Security, Config, View};
use Phalcon\Text;

class Volt extends \Phalcon\Di\Injectable
{
    public static function showField($fields, $field)
    {
        $fieldId = $field[0];
        if($fields[$fieldId]['inputType'] == "TEXT") {
            return sprintf($fields[$fieldId]['fieldDesc'], $field[2]);
        } elseif ($fields[$fieldId]['inputType'] == "OPTION") {
            $a = explode(",", $fields[$fieldId]['fieldDesc']);
            $b = explode(",", $fields[$fieldId]['defaultValue']);
            $idx = array_search($field[2], $b);
            return $a[$idx];
        }
    }

    public static function yourJs($whichController, $whichAction)
    {
        $virtualPath = sprintf("/yourjs/%s/%s.js", $whichController, $whichAction);
        $path = sprintf("%s/public/assets/%s", APP_MODULE_DIR, $virtualPath);
        if(file_exists($path)) {
            $src = sprintf("%s%s", Config::path('application.staticUrl'), $virtualPath);
            return '<script src="'.$src.'" type="text/javascript"></script>';
            // return \file_get_contents($path);
        } else {
            return  "";
        }
    }

    public static function yourCss($whichController, $whichAction)
    {
        $virtualPath = sprintf("/yourcss/%s/%s.css", $whichController, $whichAction);
        $path = sprintf("%s/public/assets/%s", APP_MODULE_DIR, $virtualPath);
        if(file_exists($path)) {
            $href = sprintf("%s%s", Config::path('application.staticUrl'), $virtualPath);
            return '<link href="'.$href.'" rel="stylesheet" type="text/css" />';
            // return \file_get_contents($path);
        } else {
            return  "";
        }
    }

    public static function csrfToken()
    {
        return '<input type="hidden" name="' . 
            Security::getTokenKey().'" value="'.
            Security::getToken().'" />';
    }

    public static function partial($path, $context = [])
    {
        $partialJsList = (array) View::getVar("partialJs");
        $partialJsName = basename($path, '.volt');
        $partialJsVars = lcfirst(Text::camelize($partialJsName));
        
        $partialJsPath = sprintf("%s/public/assets/yourjs/partial/%s.js", APP_MODULE_DIR, $partialJsName);
        if(\file_exists($partialJsPath)) {
            $partialJsList[] = $partialJsName.".js";
        }
        View::setVar("partialJs", $partialJsList);
        View::getVar("setJsVars")($partialJsVars, $context);
        View::partial($path, $context);
    }
}
