document.addEventListener('DOMContentLoaded', function() {
// Count-up animation
const countUpElements = document.querySelectorAll('.count-up');
countUpElements.forEach(el => {
    const target = parseInt(el.getAttribute('data-target'));
    let count = 0;
    const duration = 1000;
    const increment = target / (duration / 16);
    
    const updateCount = () => {
        count += increment;
        if (count < target) {
            el.textContent = Math.floor(count);
            requestAnimationFrame(updateCount);
        } else {
            el.textContent = target;
        }
    };
    
    updateCount();
});

// Inventory Movement Chart
const ctx = document.getElementById('inventoryChart').getContext('2d');
const inventoryChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
        datasets: [
            {
                label: 'Items Received',
                data: [120, 190, 170, 210, 180, 220, 240],
                borderColor: '#00a650',
                backgroundColor: 'rgba(0, 166, 80, 0.1)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Items Sold',
                data: [80, 150, 140, 180, 160, 200, 210],
                borderColor: '#0068b7',
                backgroundColor: 'rgba(0, 104, 183, 0.1)',
                tension: 0.3,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
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
