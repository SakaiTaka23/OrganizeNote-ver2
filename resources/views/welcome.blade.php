<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>OrganizeNote-Ver2</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('icon/favicon.svg') }}" type='image/x-icon'>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    </head>

    <body class="bg-gray-400 font-sans leading-normal tracking-normal">

        <!--Nav-->
        <nav class="bg-gray-800 p-2 mt-0 w-full">
            <!-- Add this to make the nav fixed: "fixed z-10 top-0" -->
            <div class="container mx-auto flex flex-wrap items-center">
                <div class="flex w-full md:w-1/2 justify-center md:justify-start text-white font-extrabold">
                    <div class="text-white no-underline hover:text-white hover:no-underline">
                        <span class="text-2xl pl-2"><i class="em em-grinning"></i>OrganizeNote-Ver2</span>
                    </div>
                </div>
                <div class="flex w-full content-center justify-between md:w-1/2 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <li>
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ route('userIndex') }}"
                                class="inline-block py-2 px-4 text-white no-underline">Index</a>
                            @else
                            <a href="{{ route('login') }}"
                                class="inline-block py-2 px-4 text-white no-underline">Login</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block py-2 px-4 text-white no-underline">Register</a>
                            @endif
                            @endif
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Hero-->
        <div class="container mx-auto flex flex-col md:flex-row items-center my-12 md:my-24">
            <!--Left Col-->
            <div class="flex flex-col w-full lg:w-1/2 justify-center items-start pt-12 pb-24 px-6">
                <h1 class="font-bold text-3xl my-4">OrganizeNote-Ver2</h1>
                <p class="leading-normal mb-4">
                    https://note.com というサイトで自分の記事を整理するために作成したOraganizeNote
                    動くものは完成し記事の整理はできたものの、パフォーマンスやコードの書き方で
                    多くの問題があったため書き直しました。
                </p>
                <a href="{{ route('register') }}"
                    class="bg-transparent hover:bg-gray-900 text-gray-900 hover:text-white rounded shadow hover:shadow-lg py-2 px-4 border border-gray-900 hover:border-transparent">
                    登録
                </a>
            </div>
            <!--Right Col-->
            <div class="w-full lg:w-1/2 lg:py-6 text-center">
                <img src='{{ asset('img/product-img.png') }}'>
            </div>

        </div>

    </body>

</html>