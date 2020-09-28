<x-app-layout>

    <x-slot name="header">
        Tag
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-center">
                    {{ $tags->appends(request()->input())->links() }}
                </div>

                <table class="table table-hover mt-2">
                    <thead class="thead-light">
                        <tr>
                            <th>使用タグ一覧</th>
                            <th>記事数</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                        <tr>
                            <td><a href="{{ route('tag.show',['tag'=>$tag->id]) }}">{{ $tag->name }}</a></td>
                            <td>{{ $tag->articles_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</x-app-layout>