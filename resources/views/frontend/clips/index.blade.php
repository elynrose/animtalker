@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      <h3>{{ trans('cruds.clip.title')  }} </h3>
      <p class="mb-5">Videos are only available for 9 hours. Please download as soon as you can.</p>
      <p class="processing_status"></p>
            <div class="row">
                @if(!$clips->isEmpty())
                @foreach($clips as $clip)
                @if($clip->character)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            
                        @can('character_delete')
                                        <form class="mx-2 my-2" action="{{ route('frontend.clips.destroy', $clip->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-black btn-xs pull-right" value="{{ trans('global.delete') }}"><i class="fas fa-close"></i></button>
                                        </form>
                                    @endcan
                            
                            <div class="card-body">
                                <h5 class="card-title">{{ $clip->character->name ?? '' }}</h5>

                                @if($clip->character && $clip->character->avatar)
                                <div style="position:relative;">
                                    <img src="{{ $clip->character->avatar->getUrl('thumb') }}" class="img-responsive" width="100%">
                               
                                    <!--bottom half overlay, show on hover-->
                                <div class="overlay_{{ $clip->id }}" style="padding:10px;position:absolute;bottom:0;left:10;right:10;background-color:rgba(0,0,0,0.5);overflow:hidden;height:auto;width:100%;transition: .5s ease;">
                                    <div class="text" style="color:white;font-size:12px;">{{ $clip->script ?? 'No script available' }}</div>
                                </div>

                                </div>
                                @endif
                                       
                                   
                                <p class="card-text mt-3">
                                <i class="fas fa-clock  @if($clip->status=='new' || $clip->status=='processing') fa-spin  @endif" id="clock_{{$clip->id}}"></i>
                                 <span class="badge  @if($clip->status=='processing' || $clip->status=='new') badge-primary @elseif($clip->status=='completed') badge-success @elseif($clip->status=='failed' || $clip->status=='rejected') badge-danger @endif clip_status @if($clip->status=='processing' || $clip->status=='new') waiting @endif" id="{{ $clip->id ?? ''}}" rel="{{$clip->video_id}}" data-status="{{ $clip->status ?? 'new'}}"> {{ ucfirst($clip->status) ?? '' }}</span>
                                 @if($clip->status=='failed') &nbsp; <a href="{{ route('frontend.clips.retry', ['id'=>$clip->id]) }}"><i class="fas fa-refresh"></i></a> @endif
                                 <br>
                                </p>
                               <p class="small muted">{{$clip->created_at->diffForHumans()}} <br><span class="text-muted small"> <i class="fas fa-clock"></i> {{ $clip->duration ?? '00:00:00' }}</span></p>
                                <div aria-label="Character Actions" id="actions_{{$clip->id}}"  @if($clip->video_path=='') style="visibility:hidden;"    @endif>
                                  
                                @if($clip->saved==1)
                                <a class="btn btn-primary btn-sm" id="download_{{$clip->id}}" href="{{ Storage::disk('s3')->url($clip->video_path) }}">
                                    <i class="fas fa-download"></i>  
                                </a>
                                </a>
                                @elseif($clip->saved==null)
                                   <a class="btn btn-primary btn-sm" id="download_{{$clip->id}}" href="{{ $clip->video_path }}">
                                          <i class="fas fa-download"></i>  
                                    </a>
                                @endif
                                    <a href="@if($clip->saved==null){{ route('frontend.clips.savelink') }} @else # @endif"  id="{{$clip->id}}" rel="{{ $clip->video_path }}" class="btn btn-sm btn-default save_{{ $clip->id }} @if ($clip->saved==null) save @endif"><i class="fas @if($clip->saved==1)fa-check @else fa-save @endif saving_{{ $clip->id }}"></i></a>
                                     <!--   <form class="mx-2 my-2" action="{{ route('frontend.clips.savelink') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="POST">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="clip_id" value="{{$clip->id}}">
                                            <input type="hidden" name="video_path" value="{{ $clip->video_path }}">
                                            <button type="submit" class="btn btn-danger btn-xs pull-right" value="{{ trans('global.save') }}"><i class="fas fa-save"></i></button>
                                        </form> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
@endif
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    /**/
$(function(){
    $('.save').click(function(e){
        e.preventDefault();
       
        var clip_id = $(this).attr('id');
        var video_path = $(this).attr('rel');
        var url = $(this).attr('href');
        data = {
            clip_id: clip_id,
            video_path: video_path,
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('.saving_'+clip_id).removeClass('fa-save').addClass('fa-spinner fa-spin');
         $(this).attr('disabled',true);
        $.ajax({
            url:url,
            data:data,
            cache:false,
            type:'POST',
            success:function(response){
                var obj = JSON.parse(response);
                $('.saving_'+clip_id).removeClass('fa-spinner fa-spin').addClass('fa-check');
                alert(obj.success)
                location.reload();
            },
            error:function(response){
                var obj = JSON.parse(response);
                $('.saving_'+clip_id).removeClass('fa-spinner fa-spin').addClass('fa-save');
                alert(obj.error)
                location.reload();
            }
        })
        

    });

});

    function getStatus(){
       
        $('.waiting').each(function(){
            $('.processing_status').text('Working...');
            var id = $(this).attr('id');
            var video_id = $(this).attr('rel');
            var clip_status = $(this).data('status');
            var ajax_url = "/clips/"+id+"/generate-video-status";
             //send headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //make an ajax call to get the status of the clip
            //create the url for the ajax call
            $('#clock_'+id).addClass('fa-spin');
            $.ajax({
                url: ajax_url,
                type: 'GET',
                data: {id: id},
                success: function(response){
                    console.log(response);
                    if(response.in_line > 0){
                    $('.processing_status').text('You are number '+response.in_line+' in the queue');
                    }else{
                        $('.processing_status').text('Working...');
                    }
                    //update the download link
                    $('#download_'+id).attr('href',response.video_path);
                   // $('#'+id).text(response.status);
                    if(response.status == 'completed'){
                    //make #actions visible
                    $('#actions_'+id).css('visibility','visible');
                        $('#clock_'+id).removeClass('fa-spin');
                        $('#'+id).addClass('badge-success').text('Completed');
                        location.reload();
                    }else if(response.status == 'processing'){
                        $('#'+id).addClass('badge-primary').text('Processing');
                    }else if(response.status == 'failed'){
                        location.reload();
                        $('#'+id).addClass('badge-danger').text('Failed');
                    }
                }
            });
        });
    }

        setInterval(getStatus, 3000);
  
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