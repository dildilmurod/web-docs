<?php
/**
 * Created by PhpStorm.
 * User: a_isokov
 * Date: 22.04.2016
 * Time: 14:46
 */

namespace backend\widgets\multiSelect;


use yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


/**
 * Afsuski bu widget ni bitta sahifada bir marta ishlashini ilojisi bor xolos
 * Class MenuMaker
 * @package abbosxon\multiSelect
 *
 * @property $multiSelectJsPath     string
 * @property $addDataUrl            string
 * @property $removeDataUrl         string
 * @property $data                  array
 * @property $selectedData          array
 * @property $listBoxSize           integer
 * @property $widgetNumber          integer
 * @property $rightButtonText       string
 * @property $leftButtonText        string
 * @property $rightButtonOptions    array
 * @property $leftButtonOptions     array
 * @property $rightAllButtonText    string
 * @property $leftAllButtonText     string
 * @property $rightAllButtonOptions array
 * @property $leftAllButtonOptions  array
 * @property $keyAttribute          string
 * @property $valueAttribute        string
 * @property $searchPlaceholder     string
 * @property $leftLabel             string
 * @property $rightLabel            string
 */

class MultiSelect extends yii\bootstrap\Widget
{
    public $widgetNumber            = 1;
    public $multiSelectJsPath       = null;
    public $leftLabel               = false;
    public $rightLabel              = false;
    public $searchPlaceholder       = null;
    public $addDataUrl              = null;
    public $keyAttribute            = null;
    public $valueAttribute          = null;
    public $removeDataUrl           = null;
    public $data                    = null;
    public $selectedData            = null;
    public $listBoxSize             = 8;
    public $leftButtonText          = '<i class="glyphicon glyphicon-chevron-right"></i>';
    public $rightButtonText         = '<i class="glyphicon glyphicon-chevron-left"></i>';
    public $rightButtonOptions      = [];
    public $leftButtonOptions       = [];
    public $leftAllButtonText       = '<i class="glyphicon glyphicon-forward"></i>';
    public $rightAllButtonText      = '<i class="glyphicon glyphicon-backward"></i>';
    public $leftAllButtonOptions    = [];
    public $rightAllButtonOptions   = [];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->data === null || $this->selectedData === null || $this->addDataUrl === null || $this->removeDataUrl === null || $this->keyAttribute === null || $this->valueAttribute === null || $this->multiSelectJsPath === null) {
            throw new InvalidConfigException(Yii::t('app',"Необходимо указать 'data','addDataUrl','removeDataUrl', 'keyAttribute', 'valueAttribute','multiSelectJsPath' и 'selectedData'"));
        }
        else
        {
            $this->data = ArrayHelper::map($this->data, $this->keyAttribute,$this->valueAttribute);
            $this->selectedData = ArrayHelper::map($this->selectedData, $this->keyAttribute, $this->valueAttribute);
            $this->leftButtonOptions['id']      =  'search_'.$this->widgetNumber.'_rightSelected';
            $this->leftAllButtonOptions['id']   =  'search_'.$this->widgetNumber.'_rightAll';
            $this->rightButtonOptions['id']     =  'search_'.$this->widgetNumber.'_leftSelected';
            $this->rightAllButtonOptions['id']  =  'search_'.$this->widgetNumber.'_leftAll';

            $this->leftButtonOptions['class']      =  isset($this->leftButtonOptions['class'])?$this->leftButtonOptions['class'].' btn btn-block':' btn btn-block';
            $this->leftAllButtonOptions['class']   =  isset($this->leftAllButtonOptions['class'])?$this->leftAllButtonOptions['class'].' btn btn-block':' btn btn-block';
            $this->rightButtonOptions['class']     =  isset($this->rightButtonOptions['class'])?$this->rightButtonOptions['class'].' btn btn-block':' btn btn-block';
            $this->rightAllButtonOptions['class']  =  isset($this->rightAllButtonOptions['class'])?$this->rightAllButtonOptions['class'].' btn btn-block':' btn btn-block';
            if(empty($this->searchPlaceholder))
                $this->searchPlaceholder = Yii::t('app','Поиск ...');
        }
        $this->registerAssets();
    }

    /**
     *
     */
    public function run()
    {
        return $this->render('multiSelect',[
            'data'                  => $this->data,
            'selectedData'          => $this->selectedData,
            'listBoxSize'           => $this->listBoxSize,
            'widgetNumber'          => $this->widgetNumber,
            'rightButtonText'       => $this->rightButtonText,
            'leftButtonText'        => $this->leftButtonText,
            'rightButtonOptions'    => $this->rightButtonOptions,
            'leftButtonOptions'     => $this->leftButtonOptions,
            'rightAllButtonText'    => $this->rightAllButtonText,
            'leftAllButtonText'     => $this->leftAllButtonText,
            'rightAllButtonOptions' => $this->rightAllButtonOptions,
            'leftAllButtonOptions'  => $this->leftAllButtonOptions,
            'leftLabel'             => $this->leftLabel,
            'rightLabel'            => $this->rightLabel,
        ]);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
//        $this->view->registerJsFile($this->multiSelectJsPath,['depends'=>['yii\web\YiiAsset'],'position'=>3]);
        $view = $this->getView();
        MultiSelectAsset::register($view);
        $js = <<<SCRIPT
        
        jQuery(document).ready(function($) {
                $('#search_$this->widgetNumber').multiselect( {
                        beforeMoveToRight: function(left, right, options) {                            
                            var items = new Array();
                            var result = false;
                            for (var i = 0; i<options.length; i++){
                                items[i]=$(options[i].outerHTML).attr('value');
                            }                            
                             $.ajax({
                                method: "POST",
                                url:"$this->addDataUrl",
                                data:{"multiSelectData":items},
                                async:false
                            }).done(function(respond){
                                result = (parseInt(respond) == 200);
                            }).fail(function( jqXHR, textStatus ) {
                                alert( "Request failed: " + textStatus );
                                console.log(jqXHR);
                                result=false;
                            });
                            return result;
                        },
                        beforeMoveToLeft: function(left, right, options) {                            
                            var items = new Array();
                            var result = false;
                            for (var i = 0; i<options.length; i++){
                                items[i]=$(options[i].outerHTML).attr('value');
                            }                            
                            $.ajax({
                                method: "POST",
                                url:"$this->removeDataUrl",
                                data:{"multiSelectData":items},
                                async:false
                            }).done(function(respond){
                                result = (parseInt(respond) == 200);
                            }).fail(function( jqXHR, textStatus ) {
                                alert( "Request failed: " + textStatus );
                                console.log(jqXHR);
                                result=false;
                            });
                            return result;
                        },
                        search: {
                            left: '<input type="text" name="q" class="form-control" placeholder="$this->searchPlaceholder" />',
                            right: '<input type="text" name="q" class="form-control" placeholder="$this->searchPlaceholder" />',
                        },
                        
                });
        });
        
SCRIPT;
        $this->view->registerJs($js,3);

    }

}