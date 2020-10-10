<x-app-layout>
    <x-slot name="header">
        Content
    </x-slot>

    <form method="GET" action="{{ route('searchContent') }}">
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <div class="relative">
                    <input type="text" name="content" id="content"
                        class="block w-full pl-20 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                        placeholder="目次検索 空白の場合はあいうえお順でソートします" />
                    <button type="submit"
                        class="absolute inset-y-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-l-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        検索
                    </button>
                </div>
            </label>
        </div>
    </form>


    <div class='my-3 ml-3 whitespace-no-wrap'>
        <a href="{{ route('content') }}">もっと見る</a>
    </div>


    <div class='w-full overflow-hidden rounded-lg shadow-xs'>
        <div class='w-full overflow-x-auto'>
            <table class="w-full whitespace-no-wrap mb-10">
                <thead>
                    <tr
                        class='text-lg font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800'>
                        <th class="px-4 py-3">目次</th>
                        <th class="px-4 py-3">元ページ</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($random_tableofcontents as $content)
                    @foreach ($content->articles as $article)

                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{ $content->name }}</td>
                        <td class="px-4 py-3">{{ $article->title }}</td>
                        <td class="px-4 py-3"><a href="https://note.com/{{ $noteid }}/n/{{ $article->key }}"
                                target="_blank" rel="noopener noreferrer">noteで開く</a></td>
                    </tr>

                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>