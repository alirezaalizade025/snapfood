<div class="space-y-5">
    <div class="font-bold text-2xl">
        Schedule
    </div>
    <div class="p-5 grid md:grid-cols-3 gap-5">
        <div>Saturday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.1.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.1.end" />
        <div>Sunday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.2.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.2.end" />
        <div>Mondat</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.3.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.3.end" />
        <div>Tusday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.4.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.4.end" />
        <div>Wensday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.5.start" />
        <x-time-picker placeholder="22:30" format="25" wire:model="schedule.5.end" />
        <div>Turshday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.6.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.6.end" />
        <div>Friday</div>
        <x-time-picker placeholder="08:00" format="24" wire:model="schedule.7.start" />
        <x-time-picker placeholder="22:30" format="24" wire:model="schedule.7.end" />
    </div>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex mx-auto"
        wire:click="emitSchedule">
        Fix
    </button>
</div>
