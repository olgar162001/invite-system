@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
    @include('partials.sidebar')
    <div class="container">
        <h1 class="text-center">Audit Logs</h1>
        <hr style="margin: auto; width: 8%;">

        <div class="container d-flex justify-content-start">
            <form action="{{ route('audits.clear') }}" method="POST" onsubmit="return confirm('Clear all audit logs?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger mb-3"><i class="fa fa-trash me-1"></i> Clear Logs</button>
            </form>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow">
                    <div class="card-header pb-0">
                        <h6>Audit Trail Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">OS</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Machine</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">IP Address</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($audits as $i => $audit)
                                        <tr>
                                            <td class="text-sm text-center">{{ $i + 1 }}</td>
                                            <td class="text-sm">{{ $audit->user->name ?? 'Guest' }}</td>
                                            <td class="text-sm">{{ $audit->action_type }}</td>
                                            <td class="text-sm">{{ $audit->description }}</td>
                                            <td class="text-sm">{{ $audit->os }}</td>
                                            <td class="text-sm">{{ $audit->machine }}</td>
                                            <td class="text-sm">{{ $audit->ip_address }}</td>
                                            <td class="text-sm">{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-sm text-secondary">No Audit Logs Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
