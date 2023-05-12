<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css'

        
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        'https://kit.fontawesome.com/6b37673df3.js',
        'https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js',
        'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js'
        
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
