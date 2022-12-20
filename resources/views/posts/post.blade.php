{{-- 
    This is the template used to show the post's page.
    This page will show all the infos about the post such as:
        - Title
        - Group
        - User
        - Full post description / image
        - Comments
--}}

@php
    /** @var $post '\App\Models\Post' */
    $group = $post->group()->first();
    $user = $post->user()->first();
    $comments = $post->comments()->get();
    $list_lambda = function ($p) { 
                 return ['user' => $p->user()->first(), 'content' => $p->content]; 
    };
@endphp

<x-app-layout id='post-page'>
    <div class="border-b-2 border-gray-600 mt-4 p-4">
        <div class="flex flex-row text-gray-800">
            <img src="{{ route('image.get', $group->image_id) }}" class="mx-2 w-7 h-7 rounded-full" />
            <p class="text-sm my-auto"> Posted in <a href="{{ route('group.show', $group->name) }}" class="underline">{{ $group->name }}</a> by <a href="{{ route('userpage.show', $user->name) }}" class="underline"> {{ $user->name }} </a> </p>
        </div>
        <header class="w-full flex flex-col lg:flex-row my-2 py-2 border-b-[1px]">
            <h1 class="mx-auto font-bold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h1>
        </header>
        
        <p> {{ $post->content }} </p>
    
        @if($post->image_id)
            <div class="mx-auto w-4/5 mt-3">
                <img class="max-w-full h-auto rounded-xl" src='{{ route('image.get', $post->image_id) }}'/>
            </div>
        @endif
    </div>

    <h2 class="my-3"> COMMENTS(<span id="comments-count"></span>) </h2>

    <form id="comment-form">
        @csrf
        <x-input-label for="content">
            New Comment
        </x-input-label>
        <x-textarea 
            id="content" 
            name="content"
            rows="4"
            class="block mt-1 w-full" 
            placeholder="Insert the comment's content..."
            required/>
        <input id="post_id" type="hidden" name="post_id" value="{{ $post->id}}" />
        <x-primary-button id="submit-comment">
            Confirm
        </x-primary-button>

    </form>

    <div id="comments-list" data-post="{{ $post->id }}"></div>

</x-app-layout>
