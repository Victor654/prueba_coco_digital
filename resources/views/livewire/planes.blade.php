<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{__('Create')}}
        </x-jet-button>
    </div>
    {{--The data table--}}
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nombre Del Plan</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Fecha De Finalizacion</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @if($data->count())
                @foreach($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->nombre_plan }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->fecha_finalizacion }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{!! $item->description !!}</td>
                        <td class="px-6 py-4 text-right txt-sm">
                            <x-jet-button wire:click="updateShowModal({{ $item->id }})">
                                {{__('Editar')}}
                            </x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})">
                                {{__('Eliminar')}}
                            </x-jet-button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No results found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $data->links() }}
    {{--Modal Form--}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Guardar Plan') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('nombre_plan') }}" />
                <x-jet-input id="nombre_plan" class="block mt-1 w-full" type="text" name="nombre_plan" wire:model.debounce.800ms="nombre_plan"/>
                @error('nombre_plan') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('fecha_finalizacion') }}" />
                <x-jet-input id="fecha_finalizacion" class="block mt-1 w-full" type="text" name="fecha_finalizacion" wire:model.debounce.800ms="fecha_finalizacion"/>
                @error('fecha_finalizacion') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('description') }}" />
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor
                                class="trix-content"
                                x-ref="trix"
                                wire:model.debounce.100000ms="description"
                                wire:keys="trix-content-unique-key"
                            ></trix-editor>
                        </div>
                    </div>
                </div>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Actualizar') }}
                </x-jet-danger-button>
                @else
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Crear') }}
                    </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalComfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Plan') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Estás seguro de que deseas eliminar tu plan? Una vez que se elimine su plan, todos sus recursos y datos se eliminarán permanentemente.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalComfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Eliminar Plan') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
