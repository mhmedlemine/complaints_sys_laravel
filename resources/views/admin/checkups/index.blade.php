blade
@extends('layouts.admin')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Checkups</h2>
  <div class="mb-4">
      <a href="{{ route('admin.checkups.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Create New Checkup
      </a>
  </div>
  <div class="table-responsive bg-white shadow-md rounded my-6">
      <table class="table min-w-max w-full table-auto">
          <thead>
              <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                  <th class="py-3 px-6 text-left">Code</th>
                  <th class="py-3 px-6 text-left">Entreprise</th>
                  <th class="py-3 px-6 text-left">Type</th>
                  <th class="py-3 px-6 text-left">Status</th>
                  <th class="py-3 px-6 text-left">Action Taken</th>
                  <th class="py-3 px-6 text-left">Date</th>
                  <th class="py-3 px-6 text-center">Actions</th>
              </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
              @foreach ($checkups as $checkup)
                  <tr class="border-b border-gray-200 hover:bg-gray-100">
                      <td class="py-3 px-6 text-left whitespace-nowrap">{{ $checkup->code }}</td>
                      <td class="py-3 px-6 text-left">{{ $checkup->entreprise->name }}</td>
                      <td class="py-3 px-6 text-left">
                          <span class="px-2 py-1 rounded-full text-xs {{ $checkup->type === 'complaint' ? 'bg-red-200 text-red-800' : 'bg-blue-200 text-blue-800' }}">
                              {{ ucfirst($checkup->type) }}
                          </span>
                      </td>
                      <td class="py-3 px-6 text-left">
                          <span class="px-2 py-1 rounded-full text-xs 
                              {{ $checkup->status === 'clean' ? 'bg-green-200 text-green-800' : 
                                 ($checkup->status === 'with_infractions' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                              {{ str_replace('_', ' ', ucfirst($checkup->status)) }}
                          </span>
                      </td>
                      <td class="py-3 px-6 text-left">
                          <span class="px-2 py-1 rounded-full text-xs {{ $checkup->action_taken === 'closed' ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800' }}">
                              {{ ucfirst($checkup->action_taken) }}
                          </span>
                      </td>
                      <td class="py-3 px-6 text-left">{{ $checkup->date->format('Y-m-d H:i') }}</td>
                      <td class="py-3 px-6 text-center">
                          <div class="flex item-center justify-center">
                              <a href="{{ route('admin.checkups.show', $checkup) }}" 
                                 class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                 title="View Details">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                  </svg>
                              </a>
                              @if($checkup->status === 'pending')
                              <a href="{{ route('admin.checkups.edit', $checkup) }}" 
                                 class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                 title="Edit">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                  </svg>
                              </a>
                              @endif
                              @if($checkup->status === 'with_infractions')
                              <a href="{{ route('admin.summons.create', ['checkup' => $checkup->id]) }}" 
                                 class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110"
                                 title="Create Summon">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                  </svg>
                              </a>
                              @endif
                              @if($checkup->status === 'pending')
                              <form action="{{ route('admin.checkups.delete', $checkup) }}" method="POST" class="inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" 
                                          class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" 
                                          onclick="return confirm('Are you sure you want to delete this checkup?')"
                                          title="Delete">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                      </svg>
                                  </button>
                              </form>
                              @endif
                          </div>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  </div>
  {{ $checkups->links() }}
@endsection