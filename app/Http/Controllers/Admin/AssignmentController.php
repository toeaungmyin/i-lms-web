<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    //this controller return response for api
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|integer',
                'title' => 'required|string',
                'due_date' => 'required|date',
                'file' => 'nullable|file|mimes:txt,pptx,pdf,docx,zip|max:20000',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => [
                        'status' => 'error',
                        'content' => 'Validation Failed',
                        'log' => $validator->errors()
                    ],
                ], 422);
            }

            $validatedData = $validator->validated();

            $course = Course::findOrFail($validatedData['course_id']);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $course->name . '_' . $validatedData['title'] . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('courses/assignments', $file, $fileName);
                $filePath = 'storage/courses/assignments/' . $fileName;
                $validatedData['file'] = $filePath;
            }

            $date = Carbon::createFromFormat('m/d/Y', $validatedData['due_date']);

            $formattedDate = $date->format('Y-m-d H:i:s');

            $validatedData['due_date'] = $formattedDate;

            $assignment = Assignment::create($validatedData);

            $data = [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'due_date' => Carbon::parse($assignment->due_date)->format('m/d/Y'),
                'file' => $assignment->file,
                'course_id' => $assignment->course_id,
            ];

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Assignment created successfully',
                ],
                'data' => $data
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to create assignment',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|integer',
                'title' => 'required|string',
                'due_date' => 'required|date',
                'file' => 'nullable|file|mimes:pptx,pdf,docx|max:20000',
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

            $assignment = $course->assignments()->find($id);

            if (!$assignment) {
                return response()->json([
                    'message' => 'Assignment not found',
                ], 404);
            }

            if ($request->hasFile('file')) {

                $file = $request->file('file');

                if ($assignment->file) {
                    Storage::disk('public')->delete($assignment->file);
                }

                $fileName = $course->name . '_' . $validatedData['title'] . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('courses/assignments', $file, $fileName);
                $filePath = 'storage/courses/assignments/' . $fileName;
                $validatedData['file'] = $filePath;
            }

            if ($request->has('due_date')) {
                $date = Carbon::createFromFormat('m/d/Y', $validatedData['due_date']);

                $formattedDate = $date->format('Y-m-d H:i:s');

                $validatedData['due_date'] = $formattedDate;
            }

            $assignment->update(array_filter($validatedData, function ($value) {
                return $value !== null;
            }));

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Assignment is updated successfully',
                ],
                'data' => $assignment
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to update assignment',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $assignment = Assignment::findOrFail($id);

            if ($assignment->file) {
                Storage::disk('public')->delete($assignment->file);
            }

            $assignment->delete();

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Assignment deleted successfully',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to delete assignment',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
