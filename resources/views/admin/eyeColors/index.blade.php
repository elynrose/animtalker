@extends('layouts.admin')
@section('content')
@can('eye_color_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.eye-colors.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eyeColor.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.eyeColor.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EyeColor">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.eyeColor.fields.color') }}
                        </th>
                        <th>
                            {{ trans('cruds.eyeColor.fields.icon') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eyeColors as $key => $eyeColor)
                        <tr data-entry-id="{{ $eyeColor->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $eyeColor->color ?? '' }}
                            </td>
                            <td>
                                @if($eyeColor->icon)
                                    <a href="{{ $eyeColor->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $eyeColor->icon->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('eye_color_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.eye-colors.show', $eyeColor->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('eye_color_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.eye-colors.edit', $eyeColor->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('eye_color_delete')
                                    <form action="{{ route('admin.eye-colors.destroy', $eyeColor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('eye_color_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.eye-colors.massDestroy') }}",
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
  let table = $('.datatable-EyeColor:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection