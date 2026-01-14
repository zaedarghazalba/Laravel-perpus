@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 placeholder:text-gray-400']) }}>
