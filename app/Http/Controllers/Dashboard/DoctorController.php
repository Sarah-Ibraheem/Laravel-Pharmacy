<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Doctor;
use App\Pharmacy;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors =  Doctor::all();
        return view('doctor/index',[
            "doctors" => $doctors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pharmacies = Pharmacy::all();
        return view('doctor/create',[
            "pharmacies" => $pharmacies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pharmacyName = $request->pharmacy_name;
        $pharmacy = Pharmacy::where ('name',$pharmacyName)->get('id');
        $pharmacyId = $pharmacy["0"]["id"];

        $this->validate($request , [
            'name' => 'required|min:3|unique:doctors',
            'email'=> 'required|unique:doctors',
            'password' => 'required | min:6',
            'national_id' => 'required | min:14 | max:14 | unique:doctors',
            'avatar_image' => 'required'
        ]);

        if(request()->hasFile('avatar_image')){
            $image = $request->file('avatar_image');
        }else{
            return $request;
            $image=null;
        }


        $doctor=Doctor::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => $request->password,
            'national_id' => $request->national_id,
            'pharmacy_id'=> $pharmacyId
        ]);
        $doctor->avatar=$image;
        $doctor->assignRole("doctor","doctor");
        $doctor->save();
        return redirect('dashboard/doctors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $doctor = Doctor::find($id);
        $pharmacies = Pharmacy::all();


        return view('doctor/edit',[
            "pharmacies" => $pharmacies,
            "doctor" => $doctor
        ]);
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

        $doctor = Doctor::find($id);
        $pharmacyName = $request->pharmacy_name;
        $pharmacy = Pharmacy::where ('name',$pharmacyName)->get('id');
        $pharmacyId = $pharmacy["0"]["id"];

        $this->validate($request , [
            'name' => 'required|min:3',
            'email'=> 'required',
            'password' => 'required | min:6',
            'national_id' => 'required | min:14 | max:14',
            ]);


            if(request()->hasFile('avatar_image')){
                $doctor->avatar= $request->file('avatar_image');
            }


            $doctor->update([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => $request->password,
                'national_id' => $request->national_id,
                'pharmacy_id'=> $pharmacyId,
                ]);

                return redirect('dashboard/doctors');
            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();
        return redirect()->back();
    }
}

