@props(['lists' => '', 'selected' => ''])

@if ($selected === '')
@php
$selected = []
@endphp
@endif

<select {!! $attributes->merge(['class' => 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md']) !!}>
    @foreach($lists as $index => $list)
    <option value="{{$index}}" @selected(in_array($index, $selected))>
        {{$list}}
    </option>
    @endforeach
</select>
