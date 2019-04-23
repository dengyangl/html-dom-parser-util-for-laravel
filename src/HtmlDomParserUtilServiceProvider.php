<?php

namespace HtmlDomParser\Util;

use Illuminate\Support\ServiceProvider;

class HtmlDomParserUtilServiceProvider extends ServiceProvider
{
    /**
     * @description 服务提供者延迟加载
     * @var bool
     */
    protected $defer = true;


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/oss.php' => config_path('oss.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('HtmlDomParserUtil', function(){
            return new HtmlDomParserUtil();
        });
    }

    /**
     * @description 获取由提供者提供的服务
     * @return array
     */
    public function provides(){
        return ['HtmlDomParserUtil'];
    }
}
