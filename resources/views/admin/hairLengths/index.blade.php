@extends('layouts.admin')
@section('content')
@can('hair_length_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.hair-lengths.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.hairLength.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.hairLength.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-HairLength">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.hairLength.fields.lenght') }}
                        </th>
                        <th>
                            {{ trans('cruds.hairLength.fields.icon') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hairLengths as $key => $hairLength)
                        <tr data-entry-id="{{ $hairLength->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $hairLength->lenght ?? '' }}
                            </td>
                            <td>
                                @if($hairLength->icon)
                                    <a href="{{ $hairLength->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $hairLength->icon->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('hair_length_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.hair-lengths.show', $hairLength->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('hair_length_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.hair-lengths.edit', $hairLength->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('hair_length_delete')
                                    <form action="{{ route('admin.hair-lengths.destroy', $hairLength->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@can('hair_length_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.hair-lengths.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-HairLength:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection