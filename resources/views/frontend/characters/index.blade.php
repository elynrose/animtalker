@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('character_create')
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <a class="btn btn-danger" href="{{ route('frontend.characters.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.character.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="row">
                @foreach($characters as $character)
                @if($character->avatar && method_exists($character->avatar, 'getUrl'))

                    <div class="col-md-3 mb-5">

                        <div class="card mb-6">
                        @can('character_delete')
                                        <form class=" " action="{{ route('frontend.characters.destroy', $character->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-black btn-xs pull-right mx-2 my-2" value="{{ trans('global.delete') }}"><i class="fas fa-close"></i></button>
                                        </form>
                                    @endcan
                            <div class="card-body">
                                <h6 class="card-title">{{ ucfirst($character->name) ?? '' }}</h6>
                             
                                            <a href="{{ route('frontend.myclips.create', ['id'=>$character->id]) }}">
                                                <img src="{{ $character->avatar_url }}" class="img-responsive" width="100%">
                                            </a>
                                        
                           <p></p>
                                <div aria-label="Character Actions">
                                    @can('character_show')
                                        <a class="btn btn-primary btn-sm " href="{{ route('frontend.myclips.create', ['id'=>$character->id]) }}">
                                          <i class="fas fa-video"></i> {{ _('Animate')}} 
                                        </a>
                                     <!--   <a class="btn btn-black" href="characters/version/{{ $character->id }}"><i class="fas fa-random"></i></a>-->
                                    @endcan

                                
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
@can('character_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.characters.massDestroy') }}",
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
  let table = $('.datatable-Character:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection