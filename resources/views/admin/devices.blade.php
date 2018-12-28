@extends('layouts.admin')

@section('style')
@parent
<style>
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between mt-3 px-3">
        <h3>{{ $title }}</h3>
        <a href="{{ route('admin.thingspeak.create') }}" class="btn btn-primary mr-1">
            <span class="fa fa-plus"></span> 新增設備
        </a>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Enable</th>
                <th>Party</th>
                <th>Maker</th>
                <th>Channel</th>
                <th>Fields</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td class="text-center">
                    @if ($item->active)
                    <i class="fas fa-check-circle"></i>
                    @else
                    <i class="far fa-times-circle"></i>
                    @endif
                </td>
                <td>{{ $item->party }}</td>
                <td>{{ $item->maker }}</td>
                <td>
                    <a target="_blank" href="https://thingspeak.com/channels/{{ $item->channel }}">
                        {{ $item->channel }}
                    </a>
                </td>
                <td>
                    @foreach ($item->fields_map as $type => $field)
                    <span class="field">
                        {{ ucfirst($type) }}
                        <span class="badge badge-success">{{ str_replace('field', '', $field) }}</span>
                    </span>
                    @endforeach
                </td>
                <td>{{ $item->updated_at->diffForHumans() }}</td>
                <td>
                    <button data-channel="{{ $item->channel }}" class="btn-fetch btn btn-link text-success">
                        <i class="fas fa-bolt"></i> <span class="d-none d-md-inline">Fetch</span>
                    </button>
                    <a href="{{ route('admin.thingspeak.edit', ['id' => $item->id]) }}" class="btn btn-link">
                        <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                    </a>
                    <button data-target="{{ route('admin.thingspeak.destroy', $item->id) }}" class="btn-destroy btn btn-link text-danger">
                        <i class="fas fa-trash-alt"></i> <span class="d-none d-md-inline">Delete</span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="fetchStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Latest Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <pre></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(".btn-fetch").click(function(){
        var $modal = $("#fetchStatusModal");
        var channel = $(this).data('channel');
        var template = "https://api.thingspeak.com/channels/{identity}/feeds.json?results=1";
        var url = template.replace('{identity}', channel);

        $modal.find('pre').text('Loading').end().modal('show');

        $.get(url).done(function (msg) {
            $modal.find('pre').text(JSON.stringify(msg, null, 4));
        }).fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    });

    $(".btn-destroy").click(function(){
        if (!confirm("確定刪除?")) { return; }

        var target = $(this).data('target');
        var token = $("meta[name='csrf-token']").attr('content');

        $.ajax({
            url: target,
            method: "post",
            data: {
                _method: 'delete',
                _token: token,
            },
        }).done(function (msg) {
            location.reload();
        }).fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    });
</script>
@endpush
