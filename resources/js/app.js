import './bootstrap';
import '../css/app.css'; 
// Tambahin 2 baris ini
import Alpine from 'alpinejs';
import './scalar-playground';
window.Alpine = Alpine; // Bikin jadi global (opsional tapi bagus)
Alpine.start();
