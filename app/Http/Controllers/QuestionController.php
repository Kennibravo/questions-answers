<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class QuestionController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return $this->successResponse("Showing all Questions", $questions);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:300',
            'image' => 'sometimes|image',
        ]);

        if ($request->has('image')) {
            $image = $request->file('image');
            $folder = '/uploads/images/';
            $name = 'question_' . time() . '_img';

            $filepath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);
        }

        $question = Question::create([
            'question' => $request->question,
            'user_id' => auth()->user()->id,
            'image' => $filepath ?? null,
        ]);

        return $this->createdResponse("Question successfully added", $question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return $this->successResponse("Showing Question", $question);
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
        $request->validate([
            'question' => 'required|max:300',
            'image' => 'sometimes|image',
        ]);

        if ($request->has('image')) {
            $image = $request->file('image');
            $folder = '/uploads/images/';
            $name = 'question_' . time() . '_img';

            $filepath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);
        }

        $question = Question::findOrFail($id);
        
        $question->update([
            'question' => $request->question,
            'image' => $filepath ?? null,
        ]);

        return $this->successResponse("Question successfully updated", $question);
    }

}
