<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->get();
        return view('admin.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'required|mimes:jpeg,bmp,png,jpg'
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('student'))
            {
                Storage::disk('public')->makeDirectory('student');
            }
//            resize image for upload
            $stdImg = Image::make($image)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('student/'.$imagename,$stdImg);

        } else {
            $imagename = "default.png";
        }
        $student = new Student();
        $student->name = $request->name;
        $student->image = $imagename;
        $student->save();
        return redirect()->route('student.index');
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
        $student = Student::findOrFail($id);
        return view('admin.edit',compact('student'));
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
        $student =  Student::findOrFail($id);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('student'))
            {
                Storage::disk('public')->makeDirectory('student');
            }
            //delete old image
            if (Storage::disk('public')->exists('student/'.$student->image));
            {
                Storage::disk('public')->delete('student/'.$student->image);
            }

//            resize image for upload
            $stdImg = Image::make($image)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('student/'.$imagename,$stdImg);

        } else {
            $imagename = $student->image;
        }
        $student->name = $request->name;
        $student->image = $imagename;
        $student->save();
        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student =  Student::findOrFail($id);
        if (Storage::disk('public')->exists('student/'.$student->image));
        {
            Storage::disk('public')->delete('student/'.$student->image);
        }
        $student->delete();
        return redirect()->route('student.index');
    }
}
