@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold mb-4">{{ __('messages.Dashboard') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Merchants') }}</h3>
                    <p class="text-2xl font-bold">{{ $merchantCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Entreprises') }}</h3>
                    <p class="text-2xl font-bold">{{ $entrepriseCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Summons') }}</h3>
                    <p class="text-2xl font-bold">{{ $summonCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Fines') }}</h3>
                    <p class="text-2xl font-bold">{{ $fineCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Complaints') }}</h3>
                    <p class="text-2xl font-bold">{{ $complaintCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Infractions') }}</h3>
                    <p class="text-2xl font-bold">{{ $infractionCount }}</p>
                </div>
            </div>
        </div>
    </div>

 <!-- Charts Section -->
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <!-- Entreprises by Moughataa Chart -->
      <div class="bg-white shadow-md rounded-lg p-4">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Entreprises by Moughataa') }}</h3>
          <div class="chart-container">
              <canvas id="moughataaChart"></canvas>
              <div class="chart-loading animate-pulse">
                  <div class="h-64 bg-gray-200 rounded"></div>
              </div>
          </div>
      </div>

      <!-- Entreprises by Type Chart -->
      <div class="bg-white shadow-md rounded-lg p-4">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Entreprises by Type') }}</h3>
          <div class="chart-container">
              <canvas id="typeChart"></canvas>
              <div class="chart-loading animate-pulse">
                  <div class="h-64 bg-gray-200 rounded"></div>
              </div>
          </div>
      </div>
</div>

      <!-- Recent Entreprises Table -->
      <div class="bg-white shadow-md rounded-lg p-4">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Recent Entreprises') }}</h3>
      <div class="overflow-x-auto">
          <table class="min-w-full table-auto">
              <thead class="bg-gray-50">
                  <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Name') }}</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Type') }}</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Location') }}</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Status') }}</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Registered On') }}</th>
                  </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($recentEntreprises as $entreprise)
                  <tr>
                      <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->type }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->moughataa->name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $entreprise->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                              {{ $entreprise->status }}
                          </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->created_at }}</td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>

@push('styles')
<style>
  .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
  }
  .chart-loading {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
  }
  .chart-loading.hidden {
      display: none;
  }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Common chart options
  Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
  Chart.defaults.color = '#374151'; // text-gray-700

  // Helper function to create charts with loading states
  const createChart = async (elementId, config) => {
      const canvas = document.getElementById(elementId);
      const container = canvas.parentElement;
      const loadingElement = container.querySelector('.chart-loading');

      try {
          // Show loading state
          if (loadingElement) {
              loadingElement.classList.remove('hidden');
          }

          const chart = new Chart(canvas, config);

          // Hide loading state
          if (loadingElement) {
              loadingElement.classList.add('hidden');
          }

          return chart;
      } catch (error) {
          console.error(`Error creating chart ${elementId}:`, error);
          container.innerHTML = `
              <div class="flex items-center justify-center h-full">
                  <div class="text-red-500 text-center">
                      <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p>Error loading chart</p>
                  </div>
              </div>
          `;
      }
  };

  // Moughataa Chart
  createChart('moughataaChart', {
      type: 'bar',
      data: {
          labels: @json($entreprisesByMoughataa->keys()),
          datasets: [{
              label: 'Entreprises',
              data: @json($entreprisesByMoughataa->values()),
              backgroundColor: '#3B82F6',
              borderColor: '#2563EB',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
              legend: {
                  display: false
              }
          },
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      precision: 0
                  }
              }
          }
      }
  });

  // Type Chart
  createChart('typeChart', {
      type: 'pie',
      data: {
          labels: @json($entreprisesByType->keys()),
          datasets: [{
              data: @json($entreprisesByType->values()),
              backgroundColor: [
                  '#3B82F6', // blue
                  '#10B981', // green
                  '#F59E0B', // yellow
                  '#EF4444', // red
                  '#8B5CF6', // purple
                  '#EC4899'  // pink
              ]
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
              legend: {
                  position: 'bottom'
              }
          }
      }
  });
});
</script>
@endpush
@endsection