<?php
use Illuminate\Support\Facades\Config;
 
class HomeComposer {
 
  public function compose($view)
  {
  	
    $properties = Cache::remember('properties', 60, function(){
    	return \EmilioBravo\Properties\Property::has('propertyOperations')->with('folder.files')->with('propertyOperations')->where('status','=','published')->where('sticky','=',true)->orderBy('property_type','DESC')->orderBy('created_at','DESC')->paginate(4)->getItems();
    });

    $view->with(compact('properties'));
  }
 
}