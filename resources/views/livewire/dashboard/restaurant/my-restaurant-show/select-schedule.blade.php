<div class="space-y-5 w-full">
    <div class="font-bold text-2xl">
        Schedule
    </div>
    <div class="p-5 grid md:grid-cols-2 gap-x-2">
        <div class="col-span-full mt-3 mb-1">Saturday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.1.start"
            wire:change="sendScheduleToForm" id="hi" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.1.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Sunday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.2.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.2.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Mondat</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.3.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.3.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Tusday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.4.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.4.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Wensday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.5.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.5.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Turshday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.6.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.6.end"
            wire:change="sendScheduleToForm" />
        <div class="col-span-full mt-3 mb-1">Friday</div>
        <input type="time" class="p-2 rounded-xl" placeholder="08:00" wire:model="schedule.7.start"
            wire:change="sendScheduleToForm" />
        <input type="time" class="p-2 rounded-xl" placeholder="22:30" wire:model="schedule.7.end"
            wire:change="sendScheduleToForm" />
    </div>
</div>
