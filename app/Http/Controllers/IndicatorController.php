<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indicators = Indicator::get();
        return response()->json(['indicators' => $indicators]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'nombreIndicador',
            'codigoIndicador',
            'unidadMedidaIndicador',
            'valorIndicador',
            'fechaIndicador',
            'tiempoIndicador',
            'origenIndicador',
        ]);

        $indicator = new Indicator();
        $indicator->nombreIndicador = $request->nombreIndicador;
        $indicator->codigoIndicador = $request->codigoIndicador;
        $indicator->unidadMedidaIndicador = $request->unidadMedidaIndicador;
        $indicator->valorIndicador = $request->valorIndicador;
        $indicator->fechaIndicador = $request->fechaIndicador;
        $indicator->tiempoIndicador = $request->tiempoIndicador;
        $indicator->origenIndicador = $request->origenIndicador;
        $indicator->save();
        return response()->json(['status' => 'success']);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $indicator = Indicator::find($id);
        return response()->json(['indicator' => $indicator]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'nombreIndicador',
            'codigoIndicador',
            'unidadMedidaIndicador',
            'valorIndicador',
            'fechaIndicador',
            'tiempoIndicador',
            'origenIndicador',
        ]);

        $indicator = Indicator::find($id);
        $indicator->nombreIndicador = $request->nombreIndicador;
        $indicator->codigoIndicador = $request->codigoIndicador;
        $indicator->unidadMedidaIndicador = $request->unidadMedidaIndicador;
        $indicator->valorIndicador = $request->valorIndicador;
        $indicator->fechaIndicador = $request->fechaIndicador;
        $indicator->tiempoIndicador = $request->tiempoIndicador;
        $indicator->origenIndicador = $request->origenIndicador;
        $indicator->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Indicator::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function graphic(){
        return view('graphic');
    }
}


