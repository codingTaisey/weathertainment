import './bootstrap';

import Alpine from 'alpinejs';
import { Chart, registerables } from 'chart.js';

// Chart.jsの全機能を登録
Chart.register(...registerables);

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();
