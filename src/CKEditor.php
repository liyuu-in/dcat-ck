<?php

namespace Liyuu\DcatCK;

use Dcat\Admin\Form\Field;

class CKEditor extends Field
{
	protected static $js = [
        '/vendor/dcat-ck/ckeditor/ckeditor.js',
        '/vendor/dcat-ck/ckfinder/ckfinder.js',
    ];

    protected $view = 'dcat-ck::ckeditor';

    public function render()
    {
        $filebrowserUploadUrl = route('ckfinder-connector');
        $filebrowserBrowseUrl = route('ckfinder-browser');
        $this->script = <<<EOT
        CKEDITOR.replaceAll(function (textarea, config) {
            if (textarea.classList.contains("dcat-ck") && !textarea.classList.contains("active")){
                textarea.classList.add("active");
                config.filebrowserBrowseUrl = '{$filebrowserBrowseUrl}?type=Files';
                config.filebrowserImageBrowseUrl = '{$filebrowserBrowseUrl}?type=Images';
                config.filebrowserUploadUrl = '{$filebrowserUploadUrl}?command=QuickUpload&type=Files';
                config.filebrowserImageUploadUrl = '{$filebrowserUploadUrl}?command=QuickUpload&type=Images';
                config.fullPage = textarea.dataset.full;
                return true;
            }
            return false;
        });
        EOT;

        return parent::render();
    }
}
