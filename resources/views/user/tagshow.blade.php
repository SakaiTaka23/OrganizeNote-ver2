<x-app-layout>

    <x-slot name="header">
        Tag
    </x-slot>



    <div class='flex justify-around'>
        <h2
            class='text-lg font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800'>
            タグ「{{$tag_name}}」がついている記事一覧</h2>
        <a href="{{ route('tag.index') }}"
            class="px-4 py-2 mx-5 mb-5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">タグ一覧へ戻る</a>
    </div>

    <div class='w-full overflow-hidden rounded-lg shadow-xs'>
        <div class='w-full overflow-x-auto'>
            <table class="w-full whitespace-no-wrap mb-10">
                <thead>
                    <tr
                        class='text-lg font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800'>
                        <th class="px-4 py-3">題名</th>
                        <th class="px-4 py-3">作成日</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($articles_from_tag as $article)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{ $article->title }}</td>
                        <td class="px-4 py-3">{{ $article->created_at->format('m/d H:i') }}</td>
                        <td class="px-4 py-3"><a href="https://note.com/{{ $noteid }}/n/{{ $article->key }}"
                                target="_blank" rel="noopener noreferrer">noteで開く</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</x-app-layout>