<?php
/**
 * Created by PhpStorm.
 * User: a_isokov
 * Date: 24.02.2016
 * Time: 9:03
 */


namespace common\helpers;

use common\models\Processes;
use common\models\ProcessFieldsLang;
use yii;
use yii\web\NotFoundHttpException;

/**
 * Class ModelGenerator
 * @package common\helpers
 */
Class ModelGenerator extends \yii\base\View
{
    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function generateReportModel($id)
    {
        /**
         * @var $model Processes
         */
        $model = $this->findProcessModel($id);

        $files = $this->generate($model);
        $n = count($files);
        if ($n === 0) {
            echo "No code to be generated.\n";
            return;
        }
        $answers = [];
        /**
         * @var $files CodeFile[]
         */
        foreach ($files as $file) {
            if (is_file($file->path)) {
                if (file_get_contents($file->path) === $file->content) {
                    $answers[$file->id] = false;
                } else {
                    $answers[$file->id] = true;
                }
            } else {
                $answers[$file->id] = true;
            }
        }
        if ($this->save($files, (array)$answers, $results)) {
            Yii::$app->session->addFlash('success', 'Файлы были успешно сгенерирован!');
        } else {
            Yii::$app->session->addFlash('error', 'Некоторые ошибки возникли при попытке генерации файлов.');
        }

        Yii::$app->session->addFlash('info', $results);
    }

    /**
     * Saves the generated code into files.
     * @param CodeFile[] $files the code files to be saved
     * @param array $answers
     * @param string $results this parameter receives a value from this method indicating the log messages
     * generated while saving the code files.
     * @return boolean whether files are successfully saved without any error.
     */
    protected function save($files, $answers, &$results)
    {
        $lines = [];
        $hasError = false;
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            if (isset($answers[$file->id]) && !empty($answers[$file->id]) && $file->operation !== CodeFile::OP_SKIP) {
                $error = $file->save();
                if (is_string($error)) {
                    $hasError = true;
                    $lines[] = "generating $relativePath\n<span class=\"error\">$error</span>";
                } else {
                    $lines[] = $file->operation === CodeFile::OP_CREATE ? " Файл генерирован $relativePath" : " Файл изменен $relativePath";
                }
            } else {
                $lines[] = "   Файл не изменен $relativePath";
            }
        }
        $results = implode("\n", $lines);

        return !$hasError;
    }


    /**
     * @param $process Processes
     * @return array
     */
    protected function generate($process)
    {
        $files = [];
        // model :
        $modelClassName = $process->code_name;

        $params = [
            'className' => $modelClassName,
            'rules' => $this->generateRules($process),
            'process' => $process,
        ];
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', 'common/models/reportModels')) . '/' . $modelClassName . '.php',
            $this->renderFile(Yii::getAlias('@' . str_replace('\\', '/', 'backend/views/process/generatorTemplate')) . '/' . 'model.php', $params)
        );


        return $files;
    }

    /**
     * @param $process Processes
     * @return array
     */
    protected function generateRules($process)
    {

        $types = [
            'each'      => [],
            'eachString'=> [],
            'integer'   => [],
            'string'    => [],
            'required'  => []
        ];
        $lengths = [];
        $defaults = [];
        foreach ($process->processFields as $column) {
            $langModel = $column->current_lang;
            /**
             * @var $langModel ProcessFieldsLang
             */
            if ($column->is_required == 1 && (empty(trim($langModel->default_value)) || ($column->is_multiple == 1 && in_array($column->type, ['radio','select'])))) {
                $types['required'][] = $column->code_name;
            }
            if ($column->is_multiple == 0 && $column->value_type == 'int' && in_array($column->type,['radio','select','checkbox','hidden'])) {
                $types['integer'][] = $column->code_name;
            }
            elseif ($column->is_multiple == 1 && in_array($column->type, ['radio','select'])) {
                if($column->value_type == 'string')
                    $types['eachString'][] = $column->code_name;
                else
                    $types['each'][] = $column->code_name;
            }
            else {
                $types['string'][] = $column->code_name;
            }
            if (!empty($langModel->default_value) && !in_array($column->code_name, $types['eachString']) && !in_array($column->code_name, $types['each'])) {
                $defaults[$column->code_name] = $langModel->default_value;
            }
        }
        $rules = [];
        foreach ($defaults as $column => $defaultValue) {
            $rules[] = "[['" . $column . "'], 'default', 'value'=>'$defaultValue']";
        }
        foreach ($types as $type => $columns) {
            if(!empty($columns)) {
                if ($type == 'each')
                    $rules[] = "[['" . implode("', '", $columns) . "'], '$type', 'rule'=> ['integer']]";
                elseif ($type == 'eachString')
                    $rules[] = "[['" . implode("', '", $columns) . "'], 'each', 'rule'=> ['string']]";
                else
                    $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            }
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }
        return $rules;
    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findProcessModel($id)
    {
        if (($model = Processes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
}