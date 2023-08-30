<a href="{{$route}}"
		{{ $attributes->merge(['class' => 'border rounded p-2 flex gap-2 mt-6 items-center bg-gray-700 bg-opacity-70']) }}>
	{{$slot}}
</a>
