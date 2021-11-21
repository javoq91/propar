<?php
use Illuminate\Support\Facades\Config;
use EmilioBravo\Geoplaces\Country;

class DeseoVenderComposer {
 
  public function compose($view)
  {

    $property_types = Config::get('properties::property_types');
    foreach ($property_types as $key => $value) {
        $property_types[$value] = Lang::get('properties::default.property_types.' . $value);
        unset($property_types[$key]);
    }

    $countries = Country::all()->lists('name','id');

    $view->with(compact('property_types','countries'));
  }
 
}