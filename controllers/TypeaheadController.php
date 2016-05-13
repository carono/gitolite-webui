<?php
/**
 * Created by PhpStorm.
 * User: Карно
 * Date: 13.05.2016
 * Time: 21:51
 */

namespace app\controllers;


class TypeaheadController extends \carono\components\TypeaheadController
{
    public function actionPath($q)
    {
        $search = $q . "*";
        foreach (glob($search) as $path) {
            $this->result[] = ["id" => $path, "text" => $path];
        }
    }
}