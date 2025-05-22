@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'class' => '',
    'placeholder' => '',
    'required' => false,
    'id' => null
])

<div class="mb-4">
    @if($label)
        <label for="{{ $id ?? $name }}" class="text-sm font-semibold">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="rounded {{ $class }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes }}
    >
</div>
