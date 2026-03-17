@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:border-[#245624] focus:ring-2 focus:ring-[#245624]/40 rounded-md shadow-sm']) }}>
