@props(['trigger'])

<div x-data ="{ show: false }" @click.away="show = false">
    {{-- trigger --}}
    <div>
        {{$trigger}}
    </div>


    {{-- links --}}
    <div x-show ="show" class=" py-2 absolute bg-gray-100 mt-2 roundded-xl w-full z-50 overflow-auto max-h-52"  style="display: none">
        {{$slot}}
    </div>
</div>
