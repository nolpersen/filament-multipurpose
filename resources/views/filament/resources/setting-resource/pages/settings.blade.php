<x-filament-panels::page>
    <form wire:submit.prevent="saveSetting">
        {{ $this->formSetting }}
        {{-- @foreach ($settings as $item)
        <div class="mb-1">
            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3 mb-3" for="data.title">
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    {{ $item->display_name }}
                </span> 
            </label>
        </div>
        @if ($item->type == 'textinput')
            <div class="mb-3 grid grid-cols-12 gap-2">
                <div class="col-span-11">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            wire:model="setting.{{ $item->name }}"
                        />
                    </x-filament::input.wrapper>
                </div>
                <div class="col-span-1">
                    <x-filament::icon-button
                        icon="heroicon-m-trash"
                        wire:click="removeSetting({{ $item->id }})"
                        label="Remove"
                    />
                </div>
                
            </div>
        @endif
        @if ($item->type == 'textarea')
            <div class="mb-3 grid grid-cols-12 gap-2">
                <div class="col-span-11">
                <x-filament::input.wrapper>
                    <x-textarea name="" id=""  wire:model="setting.{{ $item->name }}" ></x-textarea>
                </x-filament::input.wrapper>
                </div>
                <div class="col-span-1">
                    <x-filament::icon-button
                        icon="heroicon-m-trash"
                        wire:click="removeSetting({{ $item->id }})"
                        label="Remove"
                    />
                </div>
            </div>
        @endif
        @if ($item->type == 'select')
            <div class="mb-3 grid grid-cols-12 gap-2">
                <div class="col-span-11">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model="setting.{{ $item->name }}">
                        @php
                            $options = [];
                            if($item->additional_info){
                                $options = json_decode($item->additional_info);
                            }
                        @endphp
                        @foreach ($options as $option => $value)
                        <option value="{{ $option }}">{{ $value }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
                </div>
                <div class="col-span-1">
                    <x-filament::icon-button
                        icon="heroicon-m-trash"
                        wire:click="removeSetting({{ $item->id }})"
                        label="Remove"
                    />
                </div>
            </div>
        @endif
            
        @endforeach --}}
        <x-filament::button class="mt-6" type="submit">
            Submit
        </x-filament::button>
    </form>
    
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button class="mt-6" type="submit">
            Create New Setting
        </x-filament::button>
    </form>
</x-filament-panels::page>
