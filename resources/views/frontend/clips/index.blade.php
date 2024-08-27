@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      
            <div class="row">
                @foreach($clips as $clip)
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $clip->character->name ?? '' }}</h5>
                             
                                       @if($clip->character->avatar)
                                                <img src="{{ $clip->character->avatar->getUrl('preview') }}" class="img-responsive" width="100%">
                                        @endif  
                                <p class="card-text mt-3 badge badge-primary">
                                <i class="fas fa-clock"></i>  {{ ucfirst($clip->status) ?? '' }}<br>
                                </p>
                                <div aria-label="Character Actions">
                                   @if($clip->video_path)
                                   <a class="btn btn-primary btn-sm " href="{{ $clip->video_path }}">
                                          <i class="fas fa-download"></i>  
                                        </a>
                                        
                                    @can('character_delete')
                                        <form class="mx-2" action="{{ route('frontend.characters.destroy', $clip->character->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-danger btn-sm" value="{{ trans('global.delete') }}"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    @else 
                                   
                                   

                                    @endif

                                  
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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