<x-filament-widgets::widget>
    <x-filament::section>
        <p>Edit My Registration Data </p>
        <a href="{{ route('forms.edit', ['country' => $this->getCountryValue()]) }}">Edit</a>
    </x-filament::section>
</x-filament-widgets::widget>
