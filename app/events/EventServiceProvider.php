<?php

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->events->subscribe(new \OrderEventSubscriber);
    $this->app->events->subscribe(new \PaymentEventSubscriber);
  }

}
