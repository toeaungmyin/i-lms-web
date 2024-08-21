<x-client-layout>
    <div class="md:mt-12 md:mx-16 flex gap-8 flex-col overflow-hidden bg-white md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 pb-24">
        @include('client.courses.partials.course-detail-heading')
        @include('client.courses.partials.course-detail-chapter')
        @include('client.courses.partials.course-detail-assignment')
        @include('client.courses.partials.course-detail-quizz')
    </div>
</x-client-layout>
