<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Zone;
use App\Models\Distance;
use App\Models\Fuel_Rates;
use Illuminate\Http\Request;
use App\Models\FuelRate;
use App\Models\Station;
use App\Models\Calander;
use App\Models\Designation;
use App\Imports\CitysImport;
use App\Helper\CityImportCsv;
use App\Helper\ZoneImportCsv;
use Carbon;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function city()
    {
        $cities = City::orderBy('name','ASC')->get();
         return view('location.city')->with([
            'cities'=>$cities
        ]);
    }
     public function cityStore(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:cities']
        ],['name.unique'=> 'City name has already been taken']);
        $city = new City();
        $city->name = $request->name;
        $city->save();
        return back()->with('success', ' City has been adedd successfully!');
    }
    public function cityEdit($id)
    {
        $city = City::findOrFail($id);
        return view('location.cityUpdate',compact('city'));
    }
    public function cityUpdate(Request $request,$id)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:cities']
        ],['name.unique'=> 'City name has already been taken']);
        $city = City::findOrFail($id);
        $city->name = $request->name;
        $city->save();
        return redirect()->route('city')->with('success', ' City has updated successfully!');
    }
    public function cityDelete($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return back()->with('success', ' City has been deleted successfully!');
    }

    /**** Zone Part ****/
    public function zone()
    {
        $zones = Zone::orderBy('zone','ASC')->get();
        return view('location.zone')->with([
            'zones'=>$zones
        ]);
    }
    public function zoneStore(Request $request)
    {
        $validate = $request->validate([
        'zone' => ['required', 'unique:zones']
    ],['zone.unique'=> 'Zone has already been taken']);
        $zone = new Zone();
        $zone->zone = $request->zone;
        $zone->save();
        return back()->with('success', 'Zone has been adedd successfully!');
    }
    public function  zoneEdit($id)
    {
        $zone= zone::findOrFail($id);
        return view('location.zoneUpdate', compact('zone'));
    }
    public function zoneUpdate(Request $request,$id)
    {
        $validate = $request->validate([
            'zone' => ['required', 'unique:zones']
        ],['zone.unique'=> 'Zone has already been taken']);
        $zone= Zone::findOrFail($id);
        $zone->zone = $request->zone;
        $zone->save();
        return redirect()->route('zone')->with('success', 'Zone has been updated successfully!');
    }
    public function  zoneDelete($id)
    {
        $zone= Zone::findOrFail($id);
        $zone->delete();
        return back()->with('success', 'Zone has been deleted successfully!');
    }

    public function importZone(Request $request) {
        return view('location.zone_import');
    }

    public function importZoneSave(Request $request) {
        $validated = $request->validate([
            'file' => 'required|max:50000|mimes:csv,xlsx,txt',
            ],
            [
            'file.required' => 'Please choose the file first.',
        ]);

        $zoneHelper = new ZoneImportCsv($request->file('file'));
        $response = $zoneHelper->importCsv();
        if ($response) {
            return redirect()->route('zone')->with(['succesmsg' => $zoneHelper->getSuccessCount() . ' Zone inserted successfully...', 'errorcsv' => $zoneHelper->getErrors()]);
        }
        return redirect()->back()->with(['errorcsv' => $zoneHelper->getErrors()]);
    }


    /***Fuel Part ****/
    public function fuelRates()
    {
        $fuelRates = FuelRate::orderBy('id','DESC')->get();
        return view('location.fuelRates', compact('fuelRates'));
    }
    public function fuelRateStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'price' => ['required'],
            'fuel_date' => ['required'],
            ],
            ['price.required' => 'Fuel price is required'],
            ['fuel_date' => 'Fuel date is required'],
        );

        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $fuelRate = new FuelRate();
        $fuelRate->price = $request->price;
        $fuelRate->fuel_date = $request->fuel_date;
        $fuelRate->save();
        return redirect()->route('fuelRates')->with('success', 'Fuel Rate has been added successfully!');
    }
    public function fuelRateEdit($id)
    {
        $fuelRate = FuelRate::find($id);
        return view('location.editFuel', compact('fuelRate'));
    }
    public function fuelRateUpdate(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'price' => ['required'],
            'fuel_date' => ['required'],
            ],
            ['price.required' => 'Fuel price is required'],
            ['fuel_date' => 'Fuel date is required'],
        );

        $fuelRate = FuelRate::find($id);
        $fuelRate->price = $request->price;
        $fuelRate->fuel_date = $request->fuel_date;
        $fuelRate->save();
        return redirect()->route('fuelRates')->with('success', 'Fuel Rate has been updated successfully!');
    }
    public function fuelRateDelete($id)
    {
        $fuelRate = FuelRate::find($id);
        $fuelRate->delete();
        return back()->with('success', 'Fuel Rate has been deleted successfully!');
    }
    public function distance()
    {
        $cities = City::orderBy('name','ASC')->get();
        $distance = Distance::orderBy('id','DESC')->get();
        return view('location.distance')->with([
            'distance'=>$distance,
            'cities' => $cities
        ]);
    }
    public function  distanceDelete($id)
    {
        $distance= distance::findOrFail($id);
        $distance->delete();
        return back()->with('success', '  Distance has been deleted successfully!');
    }
    public function  distanceUpdate(Request $request,$id)
    {
        $validate = $request->validate([
            'city_from' => ['required'],
            'city_to' => ['required'],
            'kilometer' => ['required'],
        ]);
        $existDistance = Distance::where('city_to', $request->city_to)->where('city_from', $request->city_from)->first();
        if($existDistance){
            return back()->with('error', 'This City To and City From already exist in database!');
        }else{
            $distance = Distance::find($id);
            $distance->city_from = $request->city_from;
            $distance->city_to = $request->city_to;
            $distance->kilometer = $request->kilometer;
            $distance->save();
            return back()->with('success', 'Distance has been updated successfully!');
        }
    }
    public function distanceStore(Request $request)
    {
        $validate = $request->validate([
            'city_from' => ['required'],
            'city_to' => ['required'],
            'kilometer' => ['required'],
        ]);
        $existDistance = Distance::where('city_to', $request->city_to)->where('city_from', $request->city_from)->first();
        if($existDistance){
            return back()->with('error', 'This City To and City From already exist in database!');
        }else{
            $distance = new Distance();
            $distance->city_from = $request->city_from;
            $distance->city_to = $request->city_to;
            $distance->kilometer = $request->kilometer;
            $distance->save();
            return back()->with('success', 'Distance has been added successfully!');
        }
    }
    public function distanceEdit($id)
    {
        $distance = Distance::find($id);
        $cities = City::orderBy('name', 'ASC')->get();
        return view('location.distanceEdit', compact('distance','cities'));
    }

    public function station()
    {
        $stations = Station::orderBy('name','ASC')->get();
        return view('location.station', compact('stations'));
    }
    public function stationStore(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required']
        ]);
        $station = new Station();
        $station->name = $request->name;
        $station->save();
        return back()->with('success', 'Station has been added successfullyy!');
    }
    public function stationEdit($id)
    {
        $station = Station::find($id);
        return view('location.stationEdit', compact('station'));
    }
    public function stationUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required']
        ]);
        $station = Station::find($id);
        $station->name = $request->name;
        $station->save();
        return back()->with('success', 'Station has been updated successfullyy!');
    }
    public function stationDelete($id)
    {
        $fuelRate = Station::find($id);
        $fuelRate->delete();
        return back()->with('success', 'Station has been deleted successfully!');
    }

    /***Calander part ****/
    public function calander()
    {
        $calander = Calander::orderBy('date_from','ASC')->get();

        // dd($calander);

        return view('location.calander', compact('calander'));
    }
    public function calanderStore(Request $request)
    {
        $validate = $request->validate([
            'date_to' => ['required'],
            'date_from' => ['required'],
            'desc' => ['required']
        ]);
        if($request->date_from > $request->date_to){
            return back()->with('error', 'Start date could not be grater then end date!');
        }else{
            $calander = new Calander();
            $calander->date_to = $request->date_to;
            $calander->date_from = $request->date_from;
            $calander->desc = $request->desc;
            $calander->save();
            return back()->with('success', 'Calander has been added successfully!');
        }
    }
    public function calanderEdit($id)
    {
        $calander = Calander::find($id);
        return view('location.calanderEdit', compact('calander'));
    }
    public function calanderUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'date_to' => ['required'],
            'date_from' => ['required']
        ]);
        if($request->date_from > $request->date_to){
            return back()->with('error', 'Start date could not be grater then end date!');
        }else{
            $calander = Calander::find($id);
            $calander->date_to = $request->date_to;
            $calander->date_from = $request->date_from;
            $calander->desc = $request->desc;
            $calander->save();
            return back()->with('success', 'Calander has been updated successfully!');
        }
    }
    public function calanderDelete($id)
    {
        $calander = Calander::find($id);
        $calander->delete();
        return back()->with('success', 'Calander has been deleted successfully!');
    }


    public function designation()
    {
        $designations = Designation::all();
        return view('designation.index', compact('designations'));
    }
    public function designationStore(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:designations']
        ],['name.unique'=> 'Designation has already been taken']);
        $designation = new Designation();
        $designation->name = $request->name;
        $designation->save();
        return back();
    }
    public function designationEdit(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:designations']
        ],['name.unique'=> 'Designation has already been taken']);
        $designation = Designation::find($id);
        return view('designation.update', compact('designation'));
    }
    public function designationUpdate(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->name = $request->name;
        $designation->save();
        return redirect()->route('designation')->with('success', 'Designation has been updated successfully!');
    }
    public function designationDelete(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->delete();
        return back()->with('success', 'Designation has been deleted successfully!');
    }

    public function importCity(Request $request) {
        return view('location.city_import');
    }

    public function importCitySave(Request $request) {

        $validated = $request->validate([
            'file' => 'required|max:50000|mimes:csv,xlsx,txt',
            ],
            [
            'file.required' => 'Please choose the file first.',
        ]);

        $cityHelper = new CityImportCsv($request->file('file'));
        $response = $cityHelper->importCsv();
        if ($response) {
            return redirect()->route('city')->with(['succesmsg' => $cityHelper->getSuccessCount() . ' City inserted successfully...', 'errorcsv' => $cityHelper->getErrors()]);
        }
        return redirect()->back()->with(['errorcsv' => $cityHelper->getErrors()]);
    }
}
