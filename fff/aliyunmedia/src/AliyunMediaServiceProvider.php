<?php namespace Fff\AliyunMedia;

use EasyWeChat\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use Qiniu;
use Umeng;
use Logger;
use Alidayu;

class AliyunMediaServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	public function boot()
	{
        $this->app->singleton('Fff\AliyunMedia\AliyunMediaService',function($app){
			return new AliyunMediaService();
		});
	}
}
