@extends('layouts.admin')
@section('content')
@can('skin_tone_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.skin-tones.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.skinTone.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.skinTone.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SkinTone">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.skinTone.fields.tone') }}
                        </th>
                        <th>
                            {{ trans('cruds.skinTone.fields.icon') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skinTones as $key => $skinTone)
                        <tr data-entry-id="{{ $skinTone->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $skinTone->tone ?? '' }}
                            </td>
                            <td>
                                @if($skinTone->icon)
                                    <a href="{{ $skinTone->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $skinTone->icon->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('skin_tone_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.skin-tones.show', $skinTone->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('skin_tone_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.skin-tones.edit', $skinTone->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('skin_tone_delete')
                                    <form action="{{ route('admin.skin-tones.destroy', $skinTone->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('skin_tone_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.skin-tones.massDestroy') }}",
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
  let table = $('.datatable-SkinTone:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection