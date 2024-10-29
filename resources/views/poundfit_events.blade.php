@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start justify-content-md-between mb-3">
            <h3 class="text-center"><strong>{{ __('Poundfit Events') }}</strong></h3>
            <a href="{{ route('poundfit-events.create') }}" class="btn btn-primary mb-0">
                <i class="fas fa-plus"></i>
                Create New Poundfit Event
            </a>
        </div>

        <div class="row">

            <div class="col-12">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="table" class="table-bordered table-dark table">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                                <th>Tanggal Acara</th>
                                <th>Nama Lokasi</th>
                                <th>WA PIC</th>
                                <th>Limit Peserta</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($poundfit_events as $poundfit_event)
                                <tr>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('poundfit-events.edit', $poundfit_event->id) }}"
                                                class="btn btn-info">
                                                <i class="fas fa-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete({{ $poundfit_event->id }});">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-{{ $poundfit_event->id }}"
                                            action="{{ route('poundfit-events.destroy', $poundfit_event->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')

                                            <input type="submit" style="display: none;">
                                        </form>
                                    </td>
                                    <td>{{ $poundfit_event->event_datetime }}</td>
                                    <td>{{ $poundfit_event->location->name }}</td>
                                    <td>{{ $poundfit_event->pic_whatsapp }}</td>
                                    <td>{{ $poundfit_event->registrant_limit }}</td>
                                    <td class="text-center">{!! $poundfit_event->is_published_badge !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/r-3.0.3/datatables.min.css"
        rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/r-3.0.3/datatables.min.js">
    </script>

    <script>
        let tables = new DataTable('#table', {
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],
            "order": [
                [1, "desc"]
            ]
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this location?')) {
                document.getElementById('delete-' + id).submit();
            }
        }
    </script>
@endpush