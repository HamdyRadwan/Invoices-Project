<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.sections', compact('sections'));
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
    public function store(Request $request)
    {
        /*
        $input = $request->all();
        $b_exists = sections::where('section_name', '=', $input['section_name'])->exists();
        if($b_exists){
            session()->flash('Error', 'خطأ القسم مسجل مسبقاً');
            return redirect('/sections');
//            return redirect()->back()->with(['Error' => 'خطأ القسم مسجل مسبقاً']);
        }else {
            sections::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'تم اضافة القسم بنجاح ');
            return redirect('/sections');
//            return redirect()->back()->with(['Add' => 'تم اضافه العرض بنجاح ']);
        }*/
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
            ],[
            'section_name.required'=>"يرجى ادخال اسم القسم",
            'section_name.unique'=>"اسم القسم مسجل مسبقاً",
            'description.required'=>"يرجى ادخال اسم البيان",

        ]);
        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');
//            return redirect()->back()->with(['Add' => 'تم اضافه العرض بنجاح ']);
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[
            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',
        ]);
        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        sections::find($request->id)->delete();

        session()->flash('delete','تم حذف القسم بنجاج');
        return redirect('/sections');
    }
}
