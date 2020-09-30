<x-app-layout>
    <x-slot name="header">
        Index
    </x-slot>


    <form method='GET' action="{{ route('searchArticle') }}">
        <label for="title" class="text-gray-700 dark:text-gray-400">題名：</label>
        <input type="text" id="title"
            class="w-full pl-8 pr-2 mb-5 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
            name="title" value="{{ $title ?? '' }}" autofocus>

        <label for='datefrom' class='text-gray-700 dark:text-gray-400'>期間：</label>
        <input type='date' id='datefrom'
            class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
            name='datefrom' value='{{ $dates['from'] ?? '' }}' min='2014-04-07' max='{{ $today }}' autofocus>

        <label for='dateto' class='text-gray-700 dark:text-gray-400'>〜</label>
        <input type='date' id='dateto'
            class="w-full pl-8 pr-2 mb-5 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
            name='dateto' value='{{ $dates['to'] ?? '' }}' min='2014-04-07' max='{{ $today }}' autofocus>

        <button type='submit'
            class="px-4 py-2 mx-5 mb-5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            onclick='window.checkdate()'>検索</button>
        <button type="button" onclick='window.reset()'>リセット</button>
    </form>

    <div class="flex mb-5">
        {{ $articles->appends(request()->input())->links() }}
    </div>

    <div class='w-full overflow-hidden rounded-lg shadow-lg'>
        <div class='w-full overflow-x-auto'>
            <table class="w-full whitespace-no-wrap mb-10">
                <thead>
                    <tr
                        class='text-lg font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800'>
                        <th class="px-4 py-3">題名</th>
                        <th class="px-4 py-3">作成日</th>
                        <th class="px-4 py-3">リンク</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($articles as $article)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{ $article->title }}</td>
                        <td class="px-4 py-3">{{ $article->created_at->format('m/d H:i') }}</td>
                        <td class="px-4 py-3"><a href="https://note.com/{{ $noteid }}/n/{{ $article->key }}" target="_blank"
                                rel="noopener noreferrer">noteで開く</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>

<script>
    function reset()
    {
    console.log('reset local');
    change = "";
    console.log(document.getElementById('title').value);
    document.getElementById('title').value = change;
    document.getElementById('datefrom').value = "";
    document.getElementById('dateto').value = "";
    }
    
    function checkdate()
    {
    console.log('check');
    from = document.getElementById('datefrom').value;
    to = document.getElementById('dateto').value;
    if (from > to)
    {
    tmp = from;
    document.getElementById('datefrom').value = to;
    document.getElementById('dateto').value = tmp;
    }
    }
</script>