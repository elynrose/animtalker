@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      <h3>{{ trans('cruds.clip.title')  }} </h3>
            <div class="row">
                
                @foreach($clips as $clip)
                @if($clip->character)
                    <div class="col-md-6">
                        <div class="card mb-4">
                    
                            
                            <div class="card-body">
                                <h5 class="card-title">{{ $clip->character->name ?? '' }}</h5>

                                @if($clip->saved)
                                    <video src="{{ $clip->video_path }}" class="img-responsive" width="100%" controls></video>
                                @endif
                                       
                                   
                                <p class="card-text mt-3">
                                <i class="fas fa-clock  @if($clip->status=='new' || $clip->status=='processing') fa-spin  @endif" id="clock_{{$clip->id}}"></i>
                                 <span class="badge  @if($clip->status=='processing' || $clip->status=='new') badge-primary @elseif($clip->status=='completed') badge-success @elseif($clip->status=='failed' || $clip->status=='rejected') badge-danger @endif clip_status @if($clip->status=='processing' || $clip->status=='new') waiting @endif" id="{{ $clip->id ?? ''}}" rel="{{$clip->video_id}}" data-status="{{ $clip->status ?? 'new'}}"> {{ ucfirst($clip->status) ?? '' }}</span>
                                 @if($clip->status=='failed') &nbsp; <a href="{{ route('frontend.clips.retry', ['id'=>$clip->id]) }}"><i class="fas fa-refresh"></i></a> @endif
                                 <br>
                                </p>
                               <p class="small muted">{{$clip->created_at->diffForHumans()}} <br><span class="text-muted small"> <i class="fas fa-clock"></i> {{ $clip->duration ?? '00:00:00' }}</span></p>
                                <div aria-label="Character Actions" id="actions_{{$clip->id}}"  @if($clip->video_path=='') style="visibility:hidden;"    @endif>
                                  
                               
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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