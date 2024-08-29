
<form action="{{ route('dashboard.users.store') }}" method="POST">
    @csrf
    @method('post')
    @session('message')
        <span class="text-red-800">{{ $value }}</span>
    @endsession
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="username" required />
            @error('name')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="STDID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID <span class="text-xs text-gray-500">(generated)</span></label>
            <input type="text" id="STDID" name="STDID" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled value="{{ $generated_ins_id }}" />
            @error('STDID')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone number</label>
            <input type="tel" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+959/09" pattern="^(\+959\d{9}|09\d{9})$" required />
            @error('phone')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a role</label>
            <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
        <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example@gmail.com" required />
        @error('email')
            <span class="text-red-800">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-6">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
        <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
    </div>
    <div class="mb-6">
        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
        @error('password')
            <span class="text-red-800">{{ $message }}</span>
        @enderror
    </div>
    <x-primary-button>
        {{ __('Submit') }}
    </x-primary-button>
</form>

@push('post-scripts')
    <script>
        const generated_std_id = "{{ $generated_std_id }}"
        const generated_ins_id = "{{ $generated_ins_id }}"

        const id_input =document.getElementById('STDID')
        const role_input =document.getElementById('role')

        role_input.addEventListener('change',(e)=>{
            let role = e.target.value;

            if(role == 'student'){
                id_input.value = generated_std_id;
            }else if(role == 'instructor'){
                id_input.value = generated_ins_id;
            }
        })

    </script>
@endpush
