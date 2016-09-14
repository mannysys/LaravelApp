<?php
/**
 * Created by PhpStorm.
 * User: zhoujialin
 * Date: 2016/9/9
 * Time: 15:07
 */

namespace App\Markdown;


class Markdown {

    protected $parser;

    public function __construct(Parser $parser){

        $this->parser = $parser;

    }

    public function markdown($text){

        $html = $this->parser->makeHtml($text);
        return $html;

    }

} 