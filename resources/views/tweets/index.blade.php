<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tweets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tweets.store') }}">
                        @csrf
                        <textarea name="message" id="" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="{{ __('What\'s on your mind?')}}">
                        {{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        <x-primary-button class="mt-4">{{__('Tweet')}}</x-primary-button>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                @foreach($tweets as $tweet)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <svg class="h-g w-6 -scale-x-100" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                              </svg>
                              <div class="flex-1">
                                <div class="flex justify-between items-center">                
                                        <span class="text-gray-800">{{ $tweet->user->name}}</span>
                                        @if ($tweet->created_at != $tweet->updated_at)
                                            <small class="text-sm text-gray-300"> &middot; {{ __('edited') }}</small>
                                        @endif
                                        <small class="ml-2 text-sm text-gray-300">{{ $tweet->created_at->format('j M Y, g:i a') }}</small>
                                        @if (@auth()->user()->is($tweet->user))
                                        
                                        <x-dropdown class="w-100 relative">
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path class="mb-10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                            </x-slot>
                                        
                                            <x-slot name="content" class="mt-10">
                                                <x-dropdown-link :href="route('tweets.edit', $tweet)">{{ __('Edit tweet') }}</x-dropdown-link>
                                                <form method="POST" action="{{ route('tweets.destroy', $tweet) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-dropdown-link :href="route('tweets.destroy', $tweet)" onclick="event.preventDefault(); this.closest('form').submit();">{{__('Delete tweet')}}</x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                        @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">{{ $tweet->message }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
    </div>
</x-app-layout>
