<x-app-layout>

    <x-slot name="header">
        Profile
    </x-slot>

    <!--Main Col-->
    <div id="profile" class="text-gray-700 dark:text-gray-400 w-full lg:w-3/5 rounded-lg shadow-2xl bg-white opacity-75 mx-6 lg:mx-0">

        <div class="p-4 md:p-12 text-center lg:text-left">

            <h1 class="text-3xl dark:text-gray-700 font-bold pt-8 lg:pt-0">{{ $user_info['nickname'] }}
                ({{ $user_info['urlname'] }})</h1>
            <strong>{{ $user_info['noteCount'] }}</strong>記事
            <div class='flex'>
                <div class='mr-3'>
                    <strong>{{ $user_info['followingCount'] }}</strong>フォロー
                </div>
                <div class='mx-3'>
                    <strong>{{ $user_info['followerCount'] }}</strong>フォロワー
                </div>
            </div>
            <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-teal-500 opacity-25"></div>
            <p class="pt-8 text-sm">
                {{ $user_info['profile'] }}
            </p>

            <div class="mt-6 pb-16 lg:pb-0 w-4/5 lg:w-full mx-auto flex">
                <svg class="h-6 mr-3 fill-current text-gray-600 hover:text-teal-700" role="img" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z" />
                </svg>
                {{ $user_info['twitter'] ?? '設定なし' }}
            </div>



        </div>
    </div>

</x-app-layout>