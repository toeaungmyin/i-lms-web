<form action="{{ route('dashboard.users.update',$user->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->name }}" placeholder="username" required />
            @error('name')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="STDID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student ID <span class="text-xs text-gray-500">(generated)</span></label>
            <input type="text" id="STDID" name="STDID" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->STDID }}" disabled />
            @error('sid')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone number</label>
            <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+959/09" pattern="^(\+959\d{9}|09\d{9})$" value="{{ $user->phone }}" required />
            @error('phone')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a role</label>
            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($roles as $role)
                    <option @if ($user->is_role($role->name)) selected @endif value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->email }}" placeholder="example@gmail.com" required />
        @error('email')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
    </div>
    <div class="mb-6">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
        @error('password')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
    </div>
    <div class="mb-6">
        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
    </div>
    <x-primary-button>
        {{ __('Submit') }}
    </x-primary-button>
</form>
