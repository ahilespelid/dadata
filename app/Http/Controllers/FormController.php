<?php

namespace App\Http\Controllers;

use App\Models\Form;
//use Illuminate\Http\Request;
use App\Http\Requests\MyRequest;
use MoveMoveIo\DaData\Facades\DaDataPhone;
use MoveMoveIo\DaData\Facades\DaDataName;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(){
    //return response()->json(Form::all()->toArray());
    return (0 == Form::count()) ? [null] : Form::all();
    //return (empty($all = Form::all()) ? response()->json(['ok']) : response()->json($all));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(MyRequest $request){
    $ob = new Form(); 
    foreach($request->validated() as $k=>$v){
        if('phone' == $k){$daPhone = DaDataPhone::standardization($v);
            $v = ($daPhone[0]['phone']) ?? $v;
        }
        if('name' == $k){
            $daName = DaDataName::standardization($v);
            $v = ($daName[0]['result']) ?? $v;
        }$ob->{$k} = $v;}  //dd($ob->toArray());
        try {
           $ret = ($ob->save()) ? ['result' => 'ok', 'mes' => 'Успех'] : ['result' => 'err', 'mes' => 'Отказано'];
        } catch (Exception $e) {
            $ret = ['result' => 'err', 'mes' => 'Исключение'];
        }        
return $ret;}

    /**
     * Display the specified resource.
     */
public function show(Form $form){
    return Form::findOrFail($form);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(MyRequest $request, Form $form){
    $ob = Form::findOrFail($form); $ob->fill($request->except(['form_id'])); $ob->save();
return response()->json($ob);}

/**
 * Remove the specified resource from storage.
 */
public function destroy(Form $form){
    $ob = Form::findOrFail($form);
return ($ob->delete()) ? response(null, 204) : response()->json(null);}

}