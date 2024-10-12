<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = Student::with('classroom')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('classroom', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->latest('id')
            ->paginate('5');
        // dd($data->toArray());
        return view('students.index', compact('data','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $classrooms = classroom::all();
        // dd($subjects->toArray());
        return view('students.create', compact('subjects', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //    dd($request->toArray());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('students', 'email')],
            'classroom_id' => ['required', Rule::exists('classrooms', 'id')],
            'passport_number' => 'required',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
            'subjects' => 'required|array',
            'subjects*' => [Rule::exists('subjects', 'id')],
        ]);
        try {
            $student = Student::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'classroom_id' => $data['classroom_id']
            ]);

            $student->passport()->create([
                'passport_number' => $data['passport_number'],
                'issued_date' => $data['issued_date'],
                'expiry_date' => $data['expiry_date'],
            ]);

            $student->subjects()->attach($data['subjects']);
            return redirect()
                ->route('students.index')
                ->with('alert', true);
        } catch (\Throwable $th) {
            return back()
                ->with('alert', false)
                ->with('error', $th->getMessage());
        }
    }


    public function show(Student $student)
    {

        $student->load(['classroom', 'passport', 'subjects'])->findOrFail($student->id);
        //    dd($student->toArray());
        return view('students.show', compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load(['classroom', 'passport', 'subjects'])->findOrFail($student->id);
        //    dd($student->toArray());
        $classrooms = classroom::all();
        $subjects = Subject::all();

        return view('students.edit', compact(
            'student',
            'classrooms',
            'subjects'
        ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //    dd($request->toArray());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'classroom_id' => ['required', Rule::exists('classrooms', 'id')],
            'passport_number' => 'required',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
            'subjects' => 'required|array',
            'subjects*' => [Rule::exists('subjects', 'id')],
        ]);
        try {
            $student->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'classroom_id' => $data['classroom_id']
            ]);

            $student->passport()->update([
                'passport_number' => $data['passport_number'],
                'issued_date' => $data['issued_date'],
                'expiry_date' => $data['expiry_date'],
            ]);

            $student->subjects()->sync($data['subjects']);
            return redirect()
                ->route('students.index')
                ->with('alert', true);
        } catch (\Throwable $th) {
            return back()
                ->with('alert', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return back()->with('alert', true);

        } catch (\Throwable $th) {
            back()
                ->with('alert', false)
                ->with('error', $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(Student $student)
    {
        try {
            $student->forceDelete();
            // if (!empty($student->image) && Storage::exists($student->image)) {
            //     Storage::delete($student->image);
            // }
            return back()->with('alert', true);
        } catch (\Throwable $th) {
            return back()
                ->with('alert', false)
                ->with('error', $th->getMessage());

        }
    }
}
