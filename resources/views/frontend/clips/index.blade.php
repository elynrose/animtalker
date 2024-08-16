@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('clip_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.clips.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.clip.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.clip.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Clip">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.clip.fields.character') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.clip.fields.audio_file') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.clip.fields.status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.clip.fields.video') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.clip.fields.privacy') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clips as $key => $clip)
                                    <tr data-entry-id="{{ $clip->id }}">
                                        <td>
                                            {{ $clip->character->name ?? '' }}
                                        </td>
                                        <td>
                                            @if($clip->audio_file)
                                                <a href="{{ $clip->audio_file->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ App\Models\Clip::STATUS_SELECT[$clip->status] ?? '' }}
                                        </td>
                                        <td>
                                            @if($clip->video)
                                                <a href="{{ $clip->video->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ App\Models\Clip::PRIVACY_RADIO[$clip->privacy] ?? '' }}
                                        </td>
                                        <td>
                                            @can('clip_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.clips.show', $clip->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('clip_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.clips.edit', $clip->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('clip_delete')
                                                <form action="{{ route('frontend.clips.destroy', $clip->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('clip_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.clips.massDestroy') }}",
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
  let table = $('.datatable-Clip:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection