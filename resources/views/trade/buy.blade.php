@extends('layouts.user')

@section('user.content')
    <section class="container px-4 mx-auto">
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-medium text-gray-800">{{ __('Trade') }}</h2>
        </div>
        <div class="flex flex-col mt-6">
            <div class="font-sans leading-normal tracking-normal">
                <div class="flex justify-center pt-10">
                    <div class="inline-block align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white p-10 border border-gray-200 md:rounded-lg shadow-2xl">
                            <div x-data="TradeSell()">
                                <h1 class="text-3xl font-bold mb-6">{{__('Buy')}} <span x-text="state.from_currency"></span></h1>
                                <div class="mb-4 flex space-x-4">
                                    <div class="my-6">
                                        <label for="quantity"
                                            class="block text-sm font-semibold text-gray-600">{{ __('Quantity') }}</label>
                                        <div
                                            class="p-2 mt-2 transition duration-500 ease-in-out transform border2 bg-gray-100 md:mx-auto rounded-xl sm:max-w-lg">
                                            <input @keyup="calculate()" id="quantity" x-model="state.quantity"
                                                type="number"
                                                class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-400 transition duration-500 ease-in-out transform bg-transparent border border-transparent rounded-md focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                                        </div>
                                        <span class="text-red-600 text-sm" x-text="state.errors.quantity"></span>
                                    </div>
                                    <div class="my-6">
                                        <label for="from_currency"
                                            class="block text-sm font-semibold text-gray-600">{{ __('From') }}</label>
                                        <div
                                            class="p-2 mt-2 transition duration-500 ease-in-out transform border2 bg-gray-100 md:mx-auto rounded-xl sm:max-w-lg">
                                            <select id="from_currency" x-model="state.from_currency"
                                                class="block w-full px-6 py-3 text-base text-neutral-600 placeholder-gray-400 transition duration-500 ease-in-out transform bg-transparent border border-transparent rounded-md focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->symbol }}">
                                                        {{ $currency->symbol }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-red-600 text-sm" x-text="state.errors.from_currency"></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="my-3">
                                        <label for="price"
                                            class="block text-sm font-semibold text-gray-600">{{ __('Price per') }} <span x-text="state.from_currency"></span></label>
                                        <div
                                            class="p-2 mt-2 transition duration-500 ease-in-out transform border2 bg-gray-100 md:mx-auto rounded-xl sm:max-w-lg">
                                            <input @keyup="calculate()" id="price" x-model="state.price"
                                                type="number"
                                                class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-400 transition duration-500 ease-in-out transform bg-transparent border border-transparent rounded-md focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                                        </div>
                                        <span class="text-red-600 text-sm" x-text="state.errors.price"></span>
                                    </div>
                                </div>
                                <div class="mb-4 flex space-x-4">
                                    <div class="my-3">
                                        <label for="total_amount"
                                            class="block text-sm font-semibold text-gray-600">{{ __('Total amount') }}</label>
                                        <div
                                            class="p-2 mt-2 transition duration-500 ease-in-out transform border2 bg-gray-100 md:mx-auto rounded-xl sm:max-w-lg">
                                            <input id="total_amount" x-model="state.total_amount" type="number" disabled
                                                class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-400 transition duration-500 ease-in-out transform bg-transparent border border-transparent rounded-md focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <label for="to_currency"
                                            class="block text-sm font-semibold text-gray-600">{{ __('To') }}</label>
                                        <div
                                            class="p-2 mt-2 transition duration-500 ease-in-out transform border2 bg-gray-100 md:mx-auto rounded-xl sm:max-w-lg">
                                            <select id="to_currency" x-model="state.to_currency"
                                                class="block w-full px-6 py-3 text-base text-neutral-600 placeholder-gray-400 transition duration-500 ease-in-out transform bg-transparent border border-transparent rounded-md focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                                                @foreach ($currencies as $currency)
                                                <option :disabled="state.from_currency === '{{$currency->symbol}}'" value="{{ $currency->symbol }}">
                                                    {{ $currency->symbol }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-red-600 text-sm" x-text="state.errors.to_currency"></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm font-semibold">Fee: 3.00%</p>
                                    <p class="text-sm font-semibold"  x-text="`${state.fee_amount}  ${state.to_currency}`"></p>
                                </div>
                                <div class="mt-5">
                                    <button @click="sellAction"
                                        class="flex items-center justify-center w-full px-10 py-4 text-base font-medium text-center text-white transition duration-500 ease-in-out transform bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        {{ __('Buy') }}
                                    </button>
                                </div>
                                @include('components.alert')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
