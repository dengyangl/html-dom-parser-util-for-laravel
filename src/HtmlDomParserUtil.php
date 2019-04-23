<?php

namespace HtmlDomParser\Util;

use Sunra\PhpSimple\HtmlDomParser;

/**
 * @description HtmlDomParser工具类
 * @author dyl
 * Class HtmlDomParserUtil
 * @package App\Services\HtmlDomParserUtil
 */
class HtmlDomParserUtil
{

//    private $htmlDomParserObject;
//
//    public function __construct($content){
//        $this->htmlDomParserObject = HtmlDomParser::str_get_html($content);
//    }

    /**
     * @description 获取html_dom_parser对象
     * @author dyl
     * @param $content
     * @return \simplehtmldom_1_5\simple_html_dom
     */
    public function getObject($content){
        return HtmlDomParser::str_get_html($content);
    }

    /**
     * @description 将内容中图片的域名进行替换(去掉域名)
     * @author dyl
     * @param $content
     * @param bool $is_relative_path
     * @return mixed|null|string|string[]
     */
    public function strReplaceImgDomain($content, $is_relative_path = false){
        $content_is_empty = preg_match_all('/^<p(.*?)><\/p>$/', $content);
        if ($content_is_empty) $content = '';

        if (!empty($content)) {

            if ($is_relative_path) {                        //处理没有img标签的图片路径
                if (strpos($content, config('oss.img_path')) !== false) {       //单张图片完整路径
                    $content = str_replace(config('oss.img_path'), '/', $content);
                } else {                                                            //单张图片相对路径
                    //$content_array = explode('/', $content);
                    $first_content = substr($content, 0, 1);
                    if ($first_content != '/') $content = '/' . $content;       //格式: 2018/12/04/1.jpg
                }
            } else {
                $dom = $this->getObject($content);

                $ret = $dom->find('img[src]');      //内容中有图片
                if (!empty($ret)) {
                    $regImg = '/(<img[^>]*src\s*=\s*[\"|\']?)' . str_replace('/', '\/', config('oss.img_path')) . '/i';
                    $content = preg_replace($regImg, '$1/', $content);
                }
            }

        }

        return $content;
    }

    /**
     * @description 将内容中图片的路径进行替换(组成完整路径)
     * @author dyl
     * @param $content
     * @param bool $is_relative_path
     * @return null|string|string[]
     */
    public function strReplaceImgPath($content, $is_relative_path = false){
        if (!empty($content)) {

            if ($is_relative_path) {        //是否相对路径的图片(处理没有img标签的图片的相对路径)
                $content = config('oss.endpoint') . $content;
            } else {
                $dom = $this->getObject($content);

                $ret = $dom->find('img[src]');
                if (!empty($ret)) {             //内容中有图片
                    //$content = str_replace('/upload', config('oss.img_path').'upload', $content);
                    $regImg = '/(<img[^>]*src\s*=\s*[\"|\']?)\//i';
                    $content = preg_replace($regImg, '$1' . config('oss.img_path'), $content);
                }
            }

        }

        return $content;
    }

    /**
     * @description 使用HtmlDomParser获取纯文本内容,并截取指定长度的字符
     * @author dyl
     * @param $content
     * @param int $string_start
     * @param int $string_end
     * @return string
     */
    public function mbSubStr($content, $string_start = 0, $string_end = 100){
        $dom = $this->getObject($content);

        $cut_start = config('oss.cut_start');
        if ($string_start != 0) $cut_start = $string_start;

        $cut_end = config('oss.cut_end');
        if ($string_end != 100) $cut_end = $string_end;

        return mb_substr($dom->plaintext, $cut_start, $cut_end, "UTF-8");         //获取纯文本内容
    }

    /**
     * @description 使用HtmlDomParser获取内容中的所有图片路径
     * @author dyl
     * @param $content
     * @return array
     */
    public function getImgPathArray($content){
        $image_array = [];

        $content_is_empty = preg_match_all('/^<p(.*?)><\/p>$/', $content);

        if (!$content_is_empty && !empty($content)) {   //不为<p></p>,且不为空,再处理
            $dom = $this->getObject($content);

            //获取图片路径
            $dom_img = $dom->find('img');

            if (!empty($dom_img)) {
                foreach ($dom_img as $k => $v) {
                    $image_array[] = $this->strReplaceImgDomain($v->src, true);
                }
            }
        }

        return $image_array;
    }

}
