import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

document.addEventListener('DOMContentLoaded', () => {
    const data = window.dashboardChartData;
    if (!data) return;

    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#6b7280';
    const gridColor = isDark ? '#2a3045' : '#f3f4f6';

    const formatRupiah = (val) => `Rp ${val >= 1000000 ? `${(val / 1000000).toFixed(1)}jt` : val.toLocaleString('id-ID')}`;

    if (data.revenueData?.some((value) => Number(value) > 0)) {
        new ApexCharts(document.querySelector('#chartPendapatan'), {
            series: [{ name: 'Pendapatan', data: data.revenueData }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Poppins, sans-serif',
            },
            colors: ['#f59e0b'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.04, stops: [0, 100] },
            },
            stroke: { curve: 'smooth', width: 2.5 },
            dataLabels: { enabled: false },
            xaxis: {
                categories: data.monthLabels,
                labels: { style: { colors: textColor, fontSize: '11px' } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: formatRupiah,
                },
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: (val) => `Rp ${val.toLocaleString('id-ID')}` },
            },
        }).render();
    }

    if (data.packageLabels?.length > 0) {
        new ApexCharts(document.querySelector('#chartPaket'), {
            series: [{ name: 'Total Pendapatan', data: data.packageData }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Poppins, sans-serif',
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '50%', distributed: true } },
            colors: ['#f59e0b', '#fb923c', '#f97316', '#ea580c', '#fbbf24', '#fcd34d', '#fde68a', '#fed7aa'],
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                categories: data.packageLabels,
                labels: { style: { colors: textColor, fontSize: '10px' }, trim: true, maxHeight: 60 },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: formatRupiah,
                },
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: (val) => `Rp ${val.toLocaleString('id-ID')}` },
            },
        }).render();
    }

    document.getElementById('adminThemeToggle')?.addEventListener('change', () => {
        setTimeout(() => location.reload(), 150);
    });
});
