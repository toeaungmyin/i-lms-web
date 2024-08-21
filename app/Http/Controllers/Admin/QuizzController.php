<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuizzController extends Controller
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

            $quizz = Quizz::create($validatedData);

            $data = [
                'id' => $quizz->id,
                'question' => $quizz->question,
                'answer' => $quizz->answer,
                'course_id' => $quizz->course_id,
            ];

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Quizz created successfully',
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

            $quizz = $course->quizzes()->find($id);

            if (!$quizz) {
                return response()->json([
                    'message' => 'Quizz not found',
                ], 404);
            }

            $quizz->update(array_filter($validatedData, function ($value) {
                return $value !== null;
            }));

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Quizz is updated successfully',
                ],
                'data' => $quizz
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to update quizz',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $assignment = Quizz::findOrFail($id);

            $assignment->delete();

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Quizz deleted successfully',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to delete quizz',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
