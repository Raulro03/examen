<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function create()
    {
        return view('courses.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'paddle_product_id' => 'required|string',
            'title' => 'required|string',
            'tagline' => 'required|string',
            'description' => 'required|string',
            'image_name' => 'required|string',
            'learnings' => 'required|array',
        ]);

        $course = Course::create($validated);
        return redirect()->route('courses.show', $course);
    }


    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }


    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'paddle_product_id' => 'required|string',
            'title' => 'required|string',
            'tagline' => 'required|string',
            'description' => 'required|string',
            'image_name' => 'required|string',
            'learnings' => 'required|array',
            'published_at' => 'nullable|date',
        ]);


        if ($request->has('published_at') && $course->videos->count() == 0) {
            return redirect()->back()->withErrors(['published_at' => 'El curso no tiene vídeos asociados.']);
        }

        $course->update($validated);
        return redirect()->route('courses.show', $course);
    }


    public function destroy(Course $course)
    {

        if ($course->videos->count() > 0 && $course->purchasedCourses->count() > 0) {
            return redirect()->back()->withErrors(['course' => 'Este curso tiene vídeos o ha sido comprado y no se puede eliminar.']);
        }

        $course->videos()->delete();
        $course->delete();
        return redirect()->route('courses.index');
    }

}
