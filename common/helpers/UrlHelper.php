<?php
namespace common\helpers;

use yii\web\Controller;

class UrlHelper
{
    /**
     * @param Controller $controller
     * @return null|string
     */
    public static function getUniqueId($controller)
    {
        return isset($controller->action) ? $controller->action->uniqueId : null;
    }

    /**
     * @param Controller $controller
     * @return null|string
     */
    public static function getModuleId($controller)
    {
        return isset($controller->module) ? $controller->module->id : null;
    }

    /**
     * @param Controller $controller
     * @return null|string
     */
    public static function getControllerId($controller)
    {
        return isset($controller->action->controller) ? $controller->action->controller->id : null;
    }

    /**
     * @param Controller $controller
     * @return null|string
     */
    public static function getActionId($controller)
    {
        return isset($controller->action) ? $controller->action->id : null;
    }
}