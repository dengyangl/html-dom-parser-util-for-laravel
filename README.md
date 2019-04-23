# html-dom-parser-for-laravel
处理图片路径(包含了相对路径，完整路径和富文本编辑器中图片路径的处理)，一般使用阿里云的oss进行存储

### 使用该扩展前，请先安装以下扩展
- 项目根目录composer.json文件中添加：

    "require": {
    
        ...    
        "sunra/php-simple-html-dom-parser": "1.5.2"
        ...
    }

- 命令行运行：composer update

### 使用
- 在config/app.php文件中添加以下内容：
    'providers' => [
    
        ...
        HtmlDomParser\Util\HtmlDomParserUtilServiceProvider::class
        ...
    ]

    'aliases' => [
        
        ...
        'HtmlDomParserUtil' => HtmlDomParser\Util\Facades\HtmlDomParserUtil::class
        ...
    ]
    
- 发布config配置文件(选择相应的扩展包进行发布)

    php artisan vendor:publish --provider="HtmlDomParser\Util\HtmlDomParserUtilServiceProvider"

- 配置config/oss.php文件中的信息(阿里云oss对应的信息)

    <?php
    
    return [
        'accessKeyId'       =>  '',
        'accessKeySecret'   =>  '',
        'endpoint'          =>  '',
        'img_path'          =>  '',
        //'oss_path_format'   =>  'Ym/d',        // Y年 m月 d日 具体参见date函数的传参，"/"代表目录
        //'bucket'            =>  '',            //存储空间
    ];

### 注意
1.Laravel框架的不同版本，在安装其它扩展包时，要求的版本可能不一样，请根据实际情况进行版本的调整

2.接口的更多参数说明和限制，请查看代码

3.该扩展包仅供大家参考使用，请根据各自项目的实际情况，进行修改

4.该扩展包为基础版本，目前适用于使用了VPC通道的api网关，往后有时间再进行升级和完善

5.如果有写的不够好，或者有错误的地方，望各位大神能多给建议
