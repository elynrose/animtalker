@extends('layouts.admin')
@section('content')
@can('background_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.backgrounds.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.background.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.background.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Background">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.background.fields.background_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.background.fields.scene') }}
                        </th>
                        <th>
                            {{ trans('cruds.background.fields.icon') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backgrounds as $key => $background)
                        <tr data-entry-id="{{ $background->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $background->background_title ?? '' }}
                            </td>
                            <td>
                                {{ $background->scene ?? '' }}
                            </td>
                            <td>
                                @if($background->icon)
                                    <a href="{{ $background->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $background->icon->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('background_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.backgrounds.show', $background->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('background_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.backgrounds.edit', $background->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('background_delete')
                                    <form action="{{ route('admin.backgrounds.destroy', $background->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('background_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.backgrounds.massDestroy') }}",
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
    order: [[ 2, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Background:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection