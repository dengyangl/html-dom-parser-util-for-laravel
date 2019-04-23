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

    ###### <?php
    
    return [
        
        'accessKeyId'       =>  '',
        
        'accessKeySecret'   =>  '',
        
        'endpoint'          =>  '',
        
        'img_path'          =>  '',
        
        //'oss_path_format'   =>  'Ym/d',        // Y年 m月 d日 具体参见date函数的传参，"/"代表目录
        
        //'bucket'            =>  '',            //存储空间
        
    ];
