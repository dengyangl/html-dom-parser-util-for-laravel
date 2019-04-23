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
        
        'cut_start'         =>  0,               //截取开始位置
         
        'cut_end'           =>  100,             //截取结束位置
        
        //'oss_path_format'   =>  'Ym/d',        //Y年 m月 d日 具体参见date函数的传参，"/"代表目录
        
        //'bucket'            =>  '',            //存储空间
        
    ];

- 使用示例
    
    1.添加/修改数据时：
    
      去掉图片的域名，保留相对路径入库：
    
      $pic = 'http://www.xxx.com/a.jpg';
    
      $pic = HtmlDomParserUtil::strReplaceImgDomain($pic, true);  // /a.jpg
    
      去掉富文本编辑器中图片的域名，保留相对路径入库：
    
      $description = 'aaa<img src="http://www.xxx.com/b.jpg" />';
    
      $description = HtmlDomParserUtil::strReplaceImgDomain($description);    // aaa<img src="/b.jpg" />
    
    2.读取数据的时候：
    
      补充图片完整的路径：
      
      $pic = '/a.jpg';
      $pic = HtmlDomParserUtil::strReplaceImgPath($pic, true);      // http://www.xxx.com/a.jpg
      
      $description = 'aaa<img src="/b.jpg" />';
      $description = HtmlDomParserUtil::strReplaceImgPath($description);    // aaa<img src="http://www.xxx.com/b.jpg" />

    3.过滤图片和html标签,截取部分字符串
    
      $description = 'aaa<img src="http://www.xxx.com/b.jpg" />';
      $description = HtmlDomParserUtil::mbSubStr($description);     // aaa
    
    4.获取富文本编辑器中所有图片的相对路径
      
      $description = 'aaa<img src="http://www.xxx.com/b.jpg" /><img src="http://www.xxx.com/c.jpg" />';
      $image_array = HtmlDomParserUtil::getImgPathArray($description);      // ['b.jpg', 'c.jpg']
