import './bootstrap';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'


Alpine.plugin(mask)
window.Alpine = Alpine;

// import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Alpine.start();


$('#toggleAside').click(function () {
    $('aside').toggleClass('ml-[100%]', 'slow')
}
)

