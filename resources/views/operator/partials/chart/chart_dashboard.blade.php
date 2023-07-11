<script>
    const ambilin_chart = document.getElementById('ambilin-chart');
    const paskas_chart = document.getElementById('paskas-chart');
    const sebar_chart = document.getElementById('sebar-chart');

    const labels = [<?= '"'.implode('","', $label).'"' ?>].reverse();
    const ambilin_data = {
        labels: labels,
        datasets: [
            {
                label: 'Seluruh Ambilin',
                data: [<?= '"'.implode('","', $data_ambilin_all).'"' ?>].reverse(),
                // borderColor: '#ff6384',
                // backgroundColor: '#ff6384',
            },
            {
                label: 'Ambilin Sukses',
                data: [<?= '"'.implode('","', $data_ambilin_sukses).'"' ?>].reverse(),
            }
        ]
    };
    const paskas_data = {
        labels: labels,
        datasets: [
            {
                label: 'Seluruh Paskas',
                data: [<?= '"'.implode('","', $data_paskas_all).'"' ?>].reverse(),
            },
            {
                label: 'Paskas Lolos',
                data: [<?= '"'.implode('","', $data_paskas_lolos).'"' ?>].reverse(),
            },
            {
                label: 'Paskas Laku',
                data: [<?= '"'.implode('","', $data_paskas_laku).'"' ?>].reverse(),
            },
        ]
    };
    const sebar_data = {
        labels: labels,
        datasets: [
            {
                label: 'Seluruh Sebar',
                data: [<?= '"'.implode('","', $data_sebar_all).'"' ?>].reverse(),
            },
            {
                label: 'Sebar Lolos',
                data: [<?= '"'.implode('","', $data_sebar_lolos).'"' ?>].reverse(),
            },
            {
                label: 'Sebar Laku',
                data: [<?= '"'.implode('","', $data_sebar_laku).'"' ?>].reverse(),
            },
        ]
    };

    function config(data) {
        const conf = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    title: {
                        display: false,
                        // text: 'Chart.js Line Chart'
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai'
                        },
                    }
                }
            },
        };
        return conf;
    }

    new Chart(ambilin_chart, config(ambilin_data));
    new Chart(paskas_chart, config(paskas_data));
    new Chart(sebar_chart, config(sebar_data));
</script>