<div>
    <div class="flex justify-center gap-5 my-3 mb-10">
        <div class="bg-indigo-300 rounded-xl drop-shadow-lg p-3 text-white font-bold">
            <div>Total Income</div>
            <div class="p-2 text-2xl text-center">{{ $total_income }} $</div>
        </div>
        <div class="bg-indigo-300 rounded-xl drop-shadow-lg p-3 text-white font-bold">
            <div>Total Orders</div>
            <div class="p-2 text-2xl text-center">{{ $reports->total() }} </div>
        </div>
    </div>
    {{ $normalPicker }}
    <div class="flex justify-between mb-3">
        <div class="flex gap-5">
            <x-datetime-picker without-timezone label="Start Date" placeholder="Start Date"
                parse-format="DD-MM-YYYY HH:mm" wire:model="startDate" wire:change="$refresh" />
            <x-datetime-picker without-timezone label="End Date" placeholder="End Date"
                parse-format="DD-MM-YYYY HH:mm" wire:model="endDate" wire:change="$refresh" />
        </div>
        <div>
            <input wire:model="search" type="text" class="p-3 rounded-full" placeholder="search code">
        </div>
    </div>
    <div
        class="grid grid-cols-5 text-center bg-gradient-to-r from-[#a28ddf] to-[#ec9aaf] p-2 rounded-t-xl text-white font-bold text-lg">
        <div class="capitalize">ID</div>
        <div class="capitalize">User</div>
        <div class="capitalize">Price</div>
        <div class="capitalize">Created at</div>
        <div class="capitalize">Updated at</div>
    </div>

    @forelse ($reports as $report)
        <div
            class="grid grid-cols-5 text-center bg-gradient-to-r from-[#e4dbff] to-[#ffdde6] p-2 text-indigo-500 font-bold text-lg items-center pt-3">
            <div class="capitalize">#{{ $report->id }}</div>
            <div class="capitalize">{{ $report->user->name }}</div>
            <div class="capitalize">{{ $report->total_price }} $</div>
            <div class="capitalize text-sm">{{ $report->created_at }}</div>
            <div class="capitalize text-sm">{{ $report->updated_at }}</div>
            <div class="rounded-xl col-span-full bg-gray-300 grid grid-cols-3 text-sm gap-x-5 p-3">
                <div class="bg-gray-100 rounded-xl">Food Name</div>
                <div class="bg-gray-100 rounded-xl">Quantity</div>
                <div class="bg-gray-100 rounded-xl">Price</div>
                @foreach ($report->cartFood as $food)
                    <div>{{ $food->food->name }}</div>
                    <div>{{ $food->quantity }}</div>
                    <div class="flex justify-center">
                        <div>{{ $food->price }}$</div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
    @endforelse
</div>
<div class="w-full m-auto">
    {{ $reports->links() }}
</div>

<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>
