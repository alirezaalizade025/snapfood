<div class="space-y-5">
    <div class="font-bold text-2xl">
        Schedule
    </div>
    <div class="p-5 grid md:grid-cols-3 gap-5">
        <div>Saturday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.1.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.1.close_time" />
        <div>Sunday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.2.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.2.close_time" />
        <div>Mondat</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.3.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.3.close_time" />
        <div>Tusday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.4.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.4.close_time" />
        <div>Wensday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.5.open_time" />
        <x-time-picker placeholder="22:30" format="25" wire:model="schedule.5.close_time" />
        <div>Turshday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.6.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.6.close_time" />
        <div>Friday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.7.open_time" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.7.close_time" />
    </div>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex mx-auto"
        wire:click="emitSchedule">
        Fix
    </button>
</div>
