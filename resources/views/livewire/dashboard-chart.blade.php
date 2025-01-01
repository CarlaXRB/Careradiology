<div>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <canvas id="myChart" style="max-width: 600px; max-height: 400px;"></canvas>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            const data = @json($data);
            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pacientes', 'Radiografías', 'Tomografías'],
                    datasets: [{
                        data: [data.patients, data.radiographies, data.tomographies],
                        backgroundColor: ['#5b14ab', '#5dd5dd', '#03C503'],
                        borderColor: ['#360056', '#00bcd4', '#008000'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false // Oculta la leyenda
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>
