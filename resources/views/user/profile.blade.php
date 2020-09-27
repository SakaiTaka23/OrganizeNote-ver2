<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <table class="table table-hover mt-2">
                    <thead class="thead-light">
                        <tr>
                            <th>ニックネーム</th>
                            <th>url</th>
                            <th>プロフィール</th>
                            <th>投稿数</th>
                            <th>フォロー数</th>
                            <th>フォロワー数</th>
                            <th>twitter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user_info['nickname'] }}</td>
                            <td>{{ $user_info['urlname'] }}</td>
                            <td>{{ $user_info['profile'] }}</td>
                            <td>{{ $user_info['noteCount'] }}</td>
                            <td>{{ $user_info['followingCount'] }}</td>
                            <td>{{ $user_info['followerCount'] }}</td>
                            <td>{{ $user_info['twitter'] ?? '設定なし' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</x-app-layout>