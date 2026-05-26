import Chart from 'chart.js/auto';

const palette = {
    blue:   ['rgba(20,89,184,0.82)',  'rgba(20,89,184,0.18)'],
    purple: ['rgba(123,47,247,0.82)', 'rgba(123,47,247,0.18)'],
    teal:   ['rgba(14,116,144,0.82)', 'rgba(14,116,144,0.18)'],
    multi:  [
        'rgba(20,89,184,0.78)',
        'rgba(123,47,247,0.78)',
        'rgba(14,116,144,0.78)',
        'rgba(3,105,161,0.78)',
        'rgba(109,40,217,0.78)',
        'rgba(15,118,72,0.78)',
    ],
};

const baseFont       = { family: "'ElmsSans', Arial, sans-serif", size: 12 };
const legendFont     = { family: "'ElmsSans', Arial, sans-serif", size: 13, weight: '600' };
const legendColor    = '#0d1f3c';
const axisTickColor  = '#2c4a6e';

const gridOpts = {
    color: 'rgba(160,200,240,0.25)',
    drawBorder: false,
};

function el(id) { return document.getElementById(id); }

const data = window.dashboardData ?? {};

// ── Usuarios por rol (Doughnut) ──────────────────────────────
if (el('usuariosPorRol') && data.usuariosPorRol?.length) {
    new Chart(el('usuariosPorRol'), {
        type: 'doughnut',
        data: {
            labels: data.usuariosPorRol.map(i => i.rol),
            datasets: [{
                data: data.usuariosPorRol.map(i => i.total),
                backgroundColor: palette.multi,
                borderWidth: 3,
                borderColor: 'rgba(255,255,255,0.85)',
                hoverOffset: 10,
            }],
        },
        options: {
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: legendFont,
                        color: legendColor,
                        padding: 24,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        pointStyleWidth: 12,
                        boxHeight: 10,
                    },
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed}`,
                    },
                },
            },
        },
    });
}

// ── Servicios por categoría (Horizontal bar) ─────────────────
if (el('serviciosPorCategoria') && data.serviciosPorCategoria?.length) {
    new Chart(el('serviciosPorCategoria'), {
        type: 'bar',
        data: {
            labels: data.serviciosPorCategoria.map(i => i.nombre),
            datasets: [{
                label: 'Servicios',
                data: data.serviciosPorCategoria.map(i => i.total),
                backgroundColor: palette.multi,
                borderRadius: 8,
                borderSkipped: false,
            }],
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
            },
            scales: {
                x: { grid: gridOpts, ticks: { font: baseFont, color: axisTickColor, precision: 0 }, beginAtZero: true, border: { display: false } },
                y: { grid: { display: false }, ticks: { font: baseFont, color: axisTickColor }, border: { display: false } },
            },
        },
    });
}

// ── Altas por mes (Line) ─────────────────────────────────────
if (el('altasPorMes') && data.altasUsuariosPorMes?.length) {
    new Chart(el('altasPorMes'), {
        type: 'line',
        data: {
            labels: data.altasUsuariosPorMes.map(i => i.mes),
            datasets: [
                {
                    label: 'Usuarios',
                    data: data.altasUsuariosPorMes.map(i => i.total),
                    borderColor: palette.blue[0],
                    backgroundColor: palette.blue[1],
                    fill: true,
                    tension: 0.42,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: palette.blue[0],
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                },
                {
                    label: 'Servicios',
                    data: data.altasServiciosPorMes.map(i => i.total),
                    borderColor: palette.purple[0],
                    backgroundColor: palette.purple[1],
                    fill: true,
                    tension: 0.42,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: palette.purple[0],
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { font: legendFont, color: legendColor, padding: 24, usePointStyle: true, pointStyle: 'circle', pointStyleWidth: 12, boxHeight: 10 },
                },
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: legendFont, color: axisTickColor }, border: { display: false } },
                y: { grid: gridOpts, ticks: { font: baseFont, color: axisTickColor, precision: 0 }, beginAtZero: true, border: { display: false } },
            },
        },
    });
}

// ── Top categorías (Horizontal bar) ─────────────────────────
if (el('topCategorias') && data.topCategorias?.length) {
    new Chart(el('topCategorias'), {
        type: 'bar',
        data: {
            labels: data.topCategorias.map(i => i.nombre),
            datasets: [{
                label: 'Servicios',
                data: data.topCategorias.map(i => i.total),
                backgroundColor: palette.multi,
                borderRadius: 8,
                borderSkipped: false,
            }],
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
            },
            scales: {
                x: { grid: gridOpts, ticks: { font: baseFont, color: axisTickColor, precision: 0 }, beginAtZero: true, border: { display: false } },
                y: { grid: { display: false }, ticks: { font: legendFont, color: axisTickColor }, border: { display: false } },
            },
        },
    });
}
