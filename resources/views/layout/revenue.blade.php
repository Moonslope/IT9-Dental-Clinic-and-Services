{{-- Revenue --}}
<script>
    // Get the canvas element and initialize the chart
   const ctx = document.getElementById('revenueChart').getContext('2d');

   // Create the chart
   const revenueChart = new Chart(ctx, {
       type: 'line',
       data: {
           labels: ['Today', 'This Week', 'This Month', 'This Year'], 
           datasets: [{
               label: 'Revenue',
               data: [
                   @json($todayRevenue),
                   @json($weekRevenue),
                   @json($monthRevenue),
                   @json($yearRevenue)
               ], 
               borderColor: 'rgba(75, 192, 192, 1)', 
               backgroundColor: 'rgba(75, 192, 192, 0.2)', 
               fill: true,
               tension: 0.4, 
               pointRadius: 5, 
               pointBackgroundColor: 'rgba(75, 192, 192, 1)' 
           }]
       },
       options: {
           responsive: true, 
           scales: {
               x: {
                   title: {
                       display: true,
                       text: 'Time Period'
                   }
               },
               y: {
                   title: {
                       display: true,
                       text: 'Revenue (₱)'
                   },
                   beginAtZero: true 
               }
           }
       }
   });
</script>

{{-- Service Distribution --}}
<script>
    const labels = {!! json_encode($labels) !!};
   const data = {!! json_encode($data) !!};

   const pieCtx = document.getElementById('servicesPieChart').getContext('2d');

   new Chart(pieCtx, {
      type: 'pie',
      data: {
         labels: labels,
         datasets: [{
            label: 'Service Count',
            data: data,
            backgroundColor: [
               'rgba(255, 99, 132, 0.7)',
               'rgba(54, 162, 235, 0.7)',
               'rgba(255, 206, 86, 0.7)',
               'rgba(75, 192, 192, 0.7)',
               'rgba(153, 102, 255, 0.7)',
               // Add more colors if needed
            ],
            borderColor: '#fff',
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         plugins: {
            legend: {
               position: 'right'
            }
         }
      }
   });
</script>