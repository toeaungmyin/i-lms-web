<div class="flex flex-col">
    @foreach ($course->quizzes as $quizz)
        <div class="p-4">
            {!! $quizz->question !!}
        </div>
    @endforeach
</div>
