<x-app-layout>

    <x-slot name="header">
        Tag
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="flex mb-5">
                    {{ $tags->appends(request()->input())->links() }}
                </div>

                <div class='w-full overflow-hidden rounded-lg shadow-lg'>
                    <div class='w-full overflow-x-auto'>
                        <table class="w-full whitespace-no-wrap mb-10">
                            <thead>
                                <tr
                                    class='text-lg font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800'>
                                    <th class="px-4 py-3">使用タグ一覧</th>
                                    <th class="px-4 py-3">記事数</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($tags as $tag)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3"><a
                                            href="{{ route('tag.show',['tag'=>$tag->id]) }}">{{ $tag->name }}</a></td>
                                    <td class="px-4 py-3">{{ $tag->articles_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>