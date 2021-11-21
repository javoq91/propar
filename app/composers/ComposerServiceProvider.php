<?php
 
use Illuminate\Support\ServiceProvider;
 
class ComposerServiceProvider extends ServiceProvider {
 
  public function register()
  {
    $this->app->view->composer('site.layouts.default', 'DefaultLayoutComposer');
    $this->app->view->composer('site/partials/search', 'SearchComposer');
    $this->app->view->composer('site/partials/sidebar_search', 'SearchComposer');
    $this->app->view->composer('site/partials/home', 'HomeComposer');
    $this->app->view->composer('site/partials/deseo-vender', 'DeseoVenderComposer');
  }
 
}