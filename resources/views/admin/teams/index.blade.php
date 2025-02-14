@extends('layouts.admin')
@section('content')
@can('team_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.teams.create") }}">
            Add Cabang
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        Cabang List
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Team">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Nama Cabang
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $key => $team)
                    <tr data-entry-id="{{ $team->id }}">
                        <td>
                            {{ $team->id ?? '' }}
                        </td>
                        <td>
                            {{ $team->name ?? '' }}
                        </td>
                        <td>
                            @can('team_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.teams.show', $team->id) }}">
                                View
                            </a>
                            @endcan
                            @can('team_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.teams.edit', $team->id) }}">
                                Edit
                            </a>
                            @endcan
                            @can('team_delete')
                            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
                                onsubmit="return confirm('Anda Yakin Menghapus Data?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('team_delete')
        let deleteButtonTrans = '{{ trans('
        global.datatables.delete ') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.teams.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });
                if (ids.length === 0) {
                    alert('{{ trans('
                        global.datatables.zero_selected ') }}')

                    return
                }
                if (confirm('{{ trans('
                        global.areYouSure ') }}')) {
                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                            },
                            method: 'POST',
                            url: config.url,
                            data: {
                                ids: ids,
                                _method: 'DELETE'
                            }
                        })
                        .done(function () {
                            location.reload()
                        })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan
        $.extend(true, $.fn.dataTable.defaults, {
            order: [
                [1, 'desc']
            ],
            pageLength: 100,
        });
        $('.datatable-Team:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })

</script>
@endsection
