<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    //this controller return response for api
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'question' => 'required|string',
                'answer' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => [
                        'status' => 'error',
                        'content' => 'Validation Failed',
                        'log' => $validator->errors()
                    ],
                ], 422);
            }

            $validatedData = $validator->validated();

            $quizz = Question::create($validatedData);

            $data = [
                'id' => $quizz->id,
                'question' => $quizz->question,
                'answer' => $quizz->answer,
                'course_id' => $quizz->course_id,
            ];

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Question created successfully',
                ],
                'data' => $data
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to create quizz',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'question' => 'required|string',
                'answer' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => [
                        'status' => 'error',
                        'content' => 'Validation Failed',
                        'log' => $validator->errors()
                    ],
                ], 422);
            }

            $validatedData = $validator->validated();

            $course = Course::findOrFail($validatedData['course_id']);

            $quizz = $course->questions()->find($id);

            if (!$quizz) {
                return response()->json([
                    'message' => 'Question not found',
                ], 404);
            }

            $quizz->update(array_filter($validatedData, function ($value) {
                return $value !== null;
            }));

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Question is updated successfully',
                ],
                'data' => $quizz
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to update question',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $assignment = Question::findOrFail($id);

            $assignment->delete();

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Question deleted successfully',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to delete question',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
