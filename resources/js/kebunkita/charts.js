import { Chart } from 'chart.js/auto';

export const chartColors = {
    primary: '#059669',
    primarySoft: 'rgba(5, 150, 105, 0.16)',
    income: '#059669',
    expense: '#f59e0b',
    grid: 'rgba(100, 116, 139, 0.12)',
    text: '#64748b',
};

export function registerChart(chart) {
    // no-op; charts are scoped to the page that created them
    return chart;
}

Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = chartColors.text;
Chart.defaults.borderColor = chartColors.grid;
