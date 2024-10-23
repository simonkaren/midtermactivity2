<div class="flex p-10 items-center flex-col">
    <h1 class="text-3xl mb-2"> {{$number}}</h1>
    <div>
        <button wire:click="decrement" type="button" class="text-white bg-purple-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
            Decrement</button>
        <button wire:click="increment" type="button" class="text-white bg-purple-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
            Increment</button>
    </div>
    
</div>
