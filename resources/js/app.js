import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Alpine.start();


$('#toggleAside').click(function () {
    $('aside').toggleClass('ml-[100%]', 'slow')
    // TODO:toggle with animate
}
)

