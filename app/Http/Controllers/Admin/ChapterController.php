<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    //this controller return response for api
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|integer',
                'title' => 'required|string',
                'description' => 'nullable|string',
                'assets' => 'nullable|array',
                'assets.*' => 'nullable|file|mimes:pptx,pdf,docx,zip,mp3,mp4|max:200000',
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

            if ($request->hasFile('assets')) {
                $assets = [];
                foreach ($request->file('assets') as $key => $file) {
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('courses/assets', $file, $fileName);
                    $assets[] = 'storage/courses/assets/' . $fileName;
                }

                $validatedData['assets'] = json_encode($assets);
            }

            $chapter = Chapter::create($validatedData);

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => $chapter->title . ' is created successfully',
                ],
                'data' => $chapter
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to create chapter',
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
                'description' => 'nullable|string',
                'assets.*' => 'nullable|file|mimes:pptx,pdf,docx,zip,mp3,mp4|max:200000',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => [
                        'status' => 'error',
                        'content' => 'Validation Failed',
                        'log' => $validator->errors(),
                    ],
                ], 422);
            }

            $validatedData = $validator->validated();

            $course = Course::findOrFail($validatedData['course_id']);

            $chapter = $course->chapters()->find($id);

            if (!$chapter) {
                return response()->json([
                    'message' => 'Chapter not found',
                ], 404);
            }

            if ($request->hasFile('assets')) {
                $assets = [];
                foreach ($request->file('assets') as $key => $file) {

                    if ($chapter->assets) {
                        foreach (json_decode($chapter->assets, true) as $asset) {
                            Storage::disk('public')->delete($asset);
                        }
                    }

                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('courses/assets', $file, $fileName);
                    $assets[] = 'storage/courses/assets/' . $fileName;
                }

                $validatedData['assets'] = json_encode($assets);
            }

            $chapter->update($validatedData);

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => $chapter->title . ' is updated successfully',
                ],
                'data' => $chapter
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to update this chapter',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $chapter = Chapter::findOrFail($id);
            $assets = json_decode($chapter->assets, true);

            foreach ($assets as $asset) {
                Storage::disk('public')->delete($asset);
            }

            $chapter->delete();

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Chapter is deleted successfully',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Failed to delete this chapter',
                    'log' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
