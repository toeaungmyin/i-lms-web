<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function startExam($id)
    {
        $authID = Auth::id();
        $course = Course::with('course_has_students')->findOrFail($id);
        $chs = $this->getEnrolledStudent($course, $authID);

        if (!$chs) {
            return $this->redirectWithError('You need to enroll in this course before starting the exam.');
        }

        if ($this->hasExceededAttempts($chs, $course)) {
            return $this->redirectWithError('You have reached the maximum number of exam attempts.');
        }

        $activeExam = $this->getOrCreateActiveExam($chs);

        if ($this->hasExceededTimeLimit($activeExam, $course)) {
            return $this->redirectWithError('The time limit for this exam has been exceeded.');
        }

        return view('client.courses.exam', compact('course', 'chs', 'activeExam'));
    }

    public function submitExam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $exam = Exam::with(['course_has_student.course'])->findOrFail($id);
            $course = $exam->course_has_student->course;
            $chs = $exam->course_has_student;

            $this->validateExamSubmission($chs, $course, $exam);

            $this->processStudentAnswers($exam, $validator->validated()['answers']);

            $examMark = $this->calculateExamMark($exam, $course);

            $exam->update([
                'submitted_at' => now(),
                'status' => 'complete',
                'mark' => $examMark,
            ]);

            if ($exam->mark > $chs->exam_mark) {
                $chs->update([
                    'exam_mark' => $exam->mark
                ]);
            }

            $chs->increment('examAttempt');

            return $this->successResponse('Exam submitted successfully', route('exam.result', $exam->id));
        } catch (\Exception $e) {
            return $this->errorResponse(
                'An error occurred while submitting the exam.',
                500,
                $e
            );
        }
    }

    private function getEnrolledStudent($course, $authID)
    {
        return $course->course_has_students()->where('student_id', $authID)->first();
    }

    private function hasExceededAttempts($chs, $course)
    {
        return $chs->examAttempt >= $course->maxExamAttempts;
    }

    private function getOrCreateActiveExam($chs)
    {
        return $chs->exams()->firstOrCreate(['status' => 'active'], [
            'course_has_student_id' => $chs->id,
            'started_at' => now(),
            'status' => 'active',
        ]);
    }

    private function hasExceededTimeLimit($exam, $course)
    {
        return now()->diffInSeconds($exam->started_at) > $course->examTimeLimit;
    }

    private function validateExamSubmission($chs, $course, $exam)
    {
        if (!$chs) {
            throw new \Exception('You are not eligible to take this exam.');
        }

        if ($this->hasExceededAttempts($chs, $course)) {
            throw new \Exception('You have used all your exam attempts.');
        }

        if ($this->hasExceededTimeLimit($exam, $course)) {
            throw new \Exception('The exam time has exceeded the limit.');
        }

        if ($exam->status === 'complete') {
            throw new \Exception('The exam has already been submitted.');
        }
    }

    private function processStudentAnswers($exam, $answers)
    {
        Answer::where('exam_id', $exam->id)->delete();

        foreach ($answers as $ans) {
            $answer = json_decode($ans);
            $question = Question::findOrFail($answer->question_id);

            Answer::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'value' => $answer->value,
                'is_correct' => $answer->value == $question->answer,
            ]);
        }
    }

    private function calculateExamMark($exam, $course)
    {
        $correctAnswers = $exam->answers()->where('is_correct', 1)->count();
        $totalAnswers = $exam->answers()->count();

        return $totalAnswers > 0 ? ($correctAnswers / $totalAnswers) * $course->exam_grade_percent : 0;
    }

    private function validationErrorResponse($errors)
    {
        return response()->json([
            'message' => [
                'status' => 'error',
                'content' => 'Validation failed.',
                'log' => $errors,
            ],
        ], 422);
    }

    private function successResponse($message, $redirectUrl)
    {
        return response()->json([
            'message' => [
                'status' => 'success',
                'content' => $message,
            ],
            'redirect_url' => $redirectUrl,
        ], 200);
    }

    private function errorResponse($message, $statusCode = 422, \Exception $e = null)
    {
        $response = [
            'message' => [
                'status' => 'error',
                'content' => $message,
            ],
        ];

        if ($e) {
            $response['message']['log'] = $e->getMessage();
        }

        return response()->json($response, $statusCode);
    }

    private function redirectWithError($message)
    {
        return redirect()->back()->with('message', [
            'status' => 'error',
            'content' => $message,
        ]);
    }

    public function showExamResult($id)
    {
        $exam = Exam::findOrFail($id);
        return view('client.courses.result', compact('exam'));
    }






}
