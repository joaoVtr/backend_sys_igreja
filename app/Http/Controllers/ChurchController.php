<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChurchRequest;
use App\Http\Requests\UpdateChurchRequest;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use Illuminate\Support\Facades\Storage;

class ChurchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $churches = Church::with('members')->get();
        return ChurchResource::collection($churches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChurchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChurchRequest $request)
    {
        $data = $request->validated();

        if ($request->has('picture')) {
            $file_name = uniqid() . "." . $request->picture->getClientOriginalExtension();

            Storage::putFileAs('images/', $request->picture, $file_name);

            $data['picture'] = 'images/' . $file_name;
        }
        $church = Church::create($data);

        return new ChurchResource($church);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function show(Church $church)
    {
        $data = Church::with('members')->find($church->id);
        return new ChurchResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChurchRequest  $request
     * @param  \App\Models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChurchRequest $request, Church $church)
    {
        $data = $request->validated();

        if ($request->has('picture')) {

            Storage::delete($request->picture->getClientOriginalName());

            $file_name = uniqid() . "." . $request->picture->getClientOriginalExtension();

            Storage::putFileAs('images/', $request->picture, $file_name);

            $data['picture'] = 'images/' . $file_name;
        }
        $church->fill($data)->save();
        return new ChurchResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function destroy(Church $church)
    {
        Church::destroy($church->id);
        return response()->json([], 204);
    }
}
