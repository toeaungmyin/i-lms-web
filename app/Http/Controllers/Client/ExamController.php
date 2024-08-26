<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Course;
use App\Models\CourseHasStudent;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Quizz;
use App\Models\StudentHasQuizz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function startExam($id)
    {
        $authID = Auth::id();
        $course = Course::findOrFail($id);

        $chs = CourseHasStudent::where('course_id', $course->id)
            ->where('student_id', $authID)
            ->first();

        if (!$chs) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'content' => 'Sorry, you need to join this course first.',
            ]);
        }

        $studentRemainAttemp = $course->maxExamAttempts - $chs->examAttempt;

        if ($studentRemainAttemp < 1) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'content' => 'Sorry, you have used all your exam attempts.',
            ]);
        }

        $activeExam = $chs->exams()->where('status', 'active')->first();

        if ($activeExam) {
            $timeTaken = Carbon::now()->diffInSeconds($activeExam->started_at);

            if ($timeTaken > $course->examTimeLimit) {
                return redirect()->back()->with('message', [
                    'status' => 'error',
                    'content' => 'Sorry, the exam time has exceeded.',
                ]);
            }
        } else {
            $activeExam = Exam::create([
                'course_has_student_id' => $chs->id,
                'started_at' => Carbon::now(),
                'status' => 'active',
            ]);
        }

        return view('client.courses.exam', compact('course', 'chs', 'activeExam'));
    }

    public function submitExam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'array|required',
            'answers.*' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'Validation Failed',
                    'log' => $validator->errors(),
                ],
            ], 422);
        }

        try {
            $validatedData = $validator->validated();
            $exam = Exam::find($id);
            $course = $exam->course_has_student->course;
            $chs = $exam->course_has_student;

            if (!$chs) {
                return response()->json([
                    'message' => [
                        'status' => 'error',
                        'content' => 'Sorry, you are not eligible to take this exam.',
                    ],
                ], 422);
            }

            $studentRemainAttemp = $course->maxExamAttempts - $chs->examAttempt;
            if ($studentRemainAttemp < 1) {
                return response()->json([
                    'message' => [
                        'status' => 'error',
                        'content' => 'Sorry, you have used all your exam attempts.',
                    ],
                ], 422);
            }

            $timeRemaining = Carbon::now()->diffInSeconds($exam->started_at);
            if ($timeRemaining > $course->examTimeLimit) {
                return response()->json([
                    'message' => [
                        'status' => 'error',
                        'content' => 'Sorry, the exam time has exceeded the limit.',
                    ],
                ], 422);
            }

            foreach ($validatedData['answers'] as $ans) {
                $answer = json_decode($ans);
                $question = Question::find($answer->question_id);

                if (!$question) {
                    return response()->json([
                        'message' => [
                            'status' => 'error',
                            'content' => 'Sorry, question not found.',
                        ],
                    ], 422);
                }

                $studentAnswer = Answer::create([
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'value' => $answer->value,
                ]);

                $studentAnswer->update(['is_correct' => $studentAnswer->answer == $question->answer ? 1 : 0,
                ]);

                $chs->update([
                    'examAttempt' => $chs->examAttempt + 1
                ]);

                $exam->update([
                    'submitted_at' => Carbon::now(),
                    'status'       => 'complete',
                ]);
            }

            return response()->json([
                'message' => [
                    'status' => 'success',
                    'content' => 'Exam submitted successfully',
                ],
                'redirect_url' => route('exam.result', $exam->id),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [
                    'status' => 'error',
                    'content' => 'An error occurred while submitting the exam.',
                    'log' => $e->getMessage(),
                    'line' => $e->getTraceAsString(),
                ],
            ], 500);
        }
    }


    public function showExamResult($id)
    {
        $exam = Exam::findOrFail($id);
        return view('client.courses.result', ['exam' => $exam]);
    }
}
