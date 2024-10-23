<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        @if(isset($this->selectedCountry) )
            <div class="mt-5">
                <x-filament::button type="submit">
                    Save Form
                </x-filament::button>
            </div>
            <div class="mt-5 float-start">
                <x-filament::button>
                    <a href="{{ route('forms.register', $this->selectedCountry) }}" class="ml-5" target="_blank" aria-autocomplete="none">Preview form!</a>
                </x-filament::button>
            </div>
            <span>NB: The form should contain at least the name, password and email fields to allow user modify his own data later !</span>
        @endif
    </form>
</x-filament::page>
