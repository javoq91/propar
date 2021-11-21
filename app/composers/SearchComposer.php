<?php
use Illuminate\Support\Facades\Config;
 
class SearchComposer {
 
  public function compose($view)
  {

    $property_types = Config::get('properties::property_types');
    foreach ($property_types as $key => $value) {
      if($value == 'lot'){
        $property_types['any_lot_lots'] = Lang::get('properties::default.property_types.' . $value);
      }else{
        $property_types[$value] = Lang::get('properties::default.property_types.' . $value);
      }
        unset($property_types[$key]);
    }
    $property_types += ['any' => ''];

    $operation_types = ['sell' => 'Venta','rent' => 'Alquiler'];

    $currencies = Config::get('properties::currencies');
    foreach ($currencies as $key => $value) {
        $currencies[$value] = Lang::get('properties::default.currencies.' . $value);
        unset($currencies[$key]);
    }

    $search_threshold = Cache::remember('search_threshold', 60, function() use($property_types,$operation_types,$currencies){

      $minmaxvalues = ['min','max'];

      $search_threshold = [];

      foreach ($minmaxvalues as $minmax)
      {

        $name = '';

        $order = ($minmax == 'min') ? 'ASC' : 'DESC';

        foreach ($currencies as $currencies_key => $value) {

          if($currencies_key!='any')
          {

            foreach ($property_types as $property_types_key => $value) {

              foreach($operation_types as $operation_types_key => $value){

                $name = $minmax . '_' . $property_types_key . '_' . $operation_types_key . '_' . $currencies_key;

                $$name = EmilioBravo\Properties\PropertyOperation::where('operation_type','=',$operation_types_key)

                ->whereHas('property',function($query) use ($property_types_key) {
                  $query->where('status','=','published')
                  ->where(function($query) use($property_types_key)
                    {
                      if($property_types_key!='any'){
                        $query->where('property_type','=',$property_types_key);
                      }
                    });
                })

                ->where(function($query) use ($currencies_key,$operation_types_key,$order)
                  {
                    $query
                    ->where('operation_type','=',$operation_types_key)
                    ->where('currency','=',$currencies_key);
                  }  
                )
                ->orderBy('price',$order)
                ->first();

                $search_threshold[$name] = ($$name)? $$name->price :(($minmax == 'min') ? 0:999999999);

              }

            }

          }

        }

      }

      return $search_threshold;

    });


    $countries = Cache::remember('countries', 60, function() {
      return DB::table('countries')->select('countries.id','countries.name','states.id as state_id','states.name as state_name','cities.id as city_id','cities.name as city_name')->join('states','states.country_id','=','countries.id')->join('cities','cities.state_id','=','states.id')->join('properties','properties.city_id','=','cities.id')->groupBy('cities.state_id')->groupBy('properties.city_id')->get();
    });

    $cities_dropdown = '<select name="city_id" class=""><option value="any">Todas las ciudades</option>';
    $current_country = 0;
    $current_state = 0;
    foreach ($countries as $country) {

      if($country->id != $current_country)
      {
        $current_country = $country->id;

        $cities_dropdown .= '<optgroup label="' . $country->name . '">';

      }

      if($country->state_id != $current_state)
      {
        $current_state = $country->state_id;

        $cities_dropdown .= '<optgroup label="Departamento: ' . $country->state_name . '">';

      }

        $selected = (Input::get('city_id') == $country->city_id) ? ' selected="selected" ' : '';
        
        $cities_dropdown .= '<option value="' . $country->city_id . '" ' . $selected . ' >' . $country->city_name . '</option>';


      if($country->state_id != $current_state)
      {
        $current_state = $country->state_id;


        $cities_dropdown .= '</optgroup>';

        $cities_dropdown .= '<optgroup label="' . $country->state_name . '">';

      }

      if($country->id != $current_country)
      {

        $cities_dropdown .= '</optgroup>';

        $cities_dropdown .= '<optgroup label="' . $country->name . '">';
      }

    }

    $cities_dropdown .= '</optgroup>';

    $cities_dropdown .= '</optgroup>';

    $cities_dropdown .= '</select>';

    $view->with(compact('operation_types','property_types','cities_dropdown','currencies','search_threshold'));
  }
 
}