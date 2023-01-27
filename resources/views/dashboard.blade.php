<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Create something unique!') }}

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded mt-4">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="bg-red-100 text-red-700 p-4 rounded mt-4">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                </div>

                <div class="p-6 text-gray-900 bg-white shadow sm:rounded-lg">
                    <form method="POST" action="{{ route('url.store') }}">
                        @csrf

                        <!-- Destination -->
                        <x-input-label for="destination" :value="__('Destination')" />

                        <x-text-input id="destination"
                            class="block p-3 mt-1 w-full bg-slate-200 rounded-lg border border-slate-600" type="url"
                            placeholder="https://example.com" size="30" name="destination" :value="old('destination')"
                            autofocus required />

                        <x-input-error :messages="$errors->get('destination')" class="mt-2" />

                        <div class="flex items-center justify-start mt-6">
                            <x-primary-button class="p-5">
                                {{ __('Shorten') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>



    @if ($data->count() > 0 )
        <div class="py-6 pb-40">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-md border-t border-slate-600">

                    <table class="table-auto w-full text-left" >
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 max-w-sm" width="200">Destination</th>
                                <th class="px-4 py-2">Shortened URL</th>
                                <th class="px-4 py-2">Views</th>
                                <th class="px-4 py-2">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td class="border px-4 py-2 max-w-sm break-words" width="200">{{ $item->destination }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ $item->getShortUrlAttribute() }}" target="_blank"
                                            class="text-blue-600">
                                            {{ $item->getShortUrlAttribute() }}
                                        </a>
                                    </td>
                                    <td class="border px-4 py-2">{{ $item->views }}</td>
                                    <td class="border px-4 py-2">{{ $item->updated_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-start p-5">
                        {{ $data->links() }}
                    </div>

                </div>
            </div>
        </div>
    @endif

</x-app-layout>
