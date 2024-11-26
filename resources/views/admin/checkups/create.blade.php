@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Create Checkup</h2>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">New Checkup</h2>

                <form id="checkupForm" action="{{ route('admin.checkups.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Step 1: Basic Information --}}
                    <div class="step" id="step1">
                        <h3 class="text-lg font-semibold mb-4">Step 1: Basic Information</h3>

                        {{-- Entreprise Selection --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Select Entreprise</label>
                            <select name="entreprise_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select an entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}">{{ $entreprise->name }}</option>
                                @endforeach
                            </select>
                            @error('entreprise_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Checkup Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Checkup Type</label>
                            <select name="type" id="checkupType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="regular">Regular Checkup</option>
                                <option value="complaint">Complaint-based Checkup</option>
                            </select>
                            @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="button" onclick="nextStep(2)" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
                    </div>

                    {{-- Step 2: Inspection Results --}}
                    <div class="step hidden" id="step2">
                        <h3 class="text-lg font-semibold mb-4">Step 2: Inspection Results</h3>

                        {{-- Status Selection --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Inspection Result</label>
                            <select name="status" id="inspectionStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="clean">Clean (No Infractions)</option>
                                <option value="with_infractions">Infractions Found</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Infractions Section --}}
                        <div id="infractionsSection" class="hidden">
                            <h4 class="font-medium mb-2">Select Infractions</h4>

                            {{-- Predefined Infractions --}}
                            @foreach($infractions as $infraction)
                            <div class="mb-3 p-3 border rounded">
                                <div class="flex items-center">
                                    <input type="checkbox"
                                        name="infractions[{{ $infraction->id }}]"
                                        class="infraction-checkbox">
                                    <label class="ml-2">{{ $infraction->label }}</label>
                                </div>
                                <div class="mt-2 hidden infraction-details">
                                    <textarea name="infraction_notes[{{ $infraction->id }}]"
                                        class="w-full rounded-md border-gray-300 shadow-sm"
                                        placeholder="Add notes for this infraction"></textarea>
                                </div>
                            </div>
                            @endforeach

                            {{-- Custom Infraction Button --}}
                            <button type="button" id="addCustomInfraction"
                                class="mt-2 bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                + Add Custom Infraction
                            </button>

                            {{-- Custom Infractions Container --}}
                            <div id="customInfractionsContainer" class="mt-3"></div>

                            {{-- Action Taken --}}
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Action Taken</label>
                                <select name="action_taken" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="none">Keep Open</option>
                                    <option value="closed">Close Entreprise</option>
                                </select>
                                @error('action_taken')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                            @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4 space-x-2">
                            <button type="button" onclick="previousStep(1)" class="bg-gray-500 text-white px-4 py-2 rounded">Previous</button>
                            <button type="submit" class="bg-green-200 text-black px-4 py-2 rounded">Submit Checkup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Step navigation
    function nextStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');
    }

    function previousStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');
    }

    // Show/hide infractions section based on status
    document.getElementById('inspectionStatus').addEventListener('change', function() {
        const infractionsSection = document.getElementById('infractionsSection');
        infractionsSection.classList.toggle('hidden', this.value !== 'with_infractions');
    });

    // Handle infraction checkboxes
    document.querySelectorAll('.infraction-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const detailsSection = this.closest('.border').querySelector('.infraction-details');
            detailsSection.classList.toggle('hidden', !this.checked);
        });
    });

    // Custom infraction handling
    let customInfractionCount = 0;
    document.getElementById('addCustomInfraction').addEventListener('click', function() {
        const container = document.getElementById('customInfractionsContainer');
        customInfractionCount++;

        const customInfractionHtml = `
              <div class="mb-3 p-3 border rounded">
                  <textarea name="custom_infractions[${customInfractionCount}][text]" 
                            class="w-full mb-2 rounded-md border-gray-300" 
                            placeholder="Describe the infraction"></textarea>
                  <textarea name="custom_infractions[${customInfractionCount}][notes]" 
                            class="w-full rounded-md border-gray-300" 
                            placeholder="Additional notes"></textarea>
                  <button type="button" 
                          onclick="this.closest('.border').remove()" 
                          class="mt-2 text-red-500 text-sm">
                      Remove
                  </button>
              </div>
          `;

        container.insertAdjacentHTML('beforeend', customInfractionHtml);
    });
</script>
@endpush


@endsection