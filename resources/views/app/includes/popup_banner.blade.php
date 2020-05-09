@if(isset($popup_banner->show_on_page))
<div class="modal fade" id="popup_banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header py-3 text-center">
        <h5 class="modal-title w-100" id="exampleModalLongTitle">{{ $popup_banner->title ?? '' }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- display bell icon if, there is no image -->
        @if($popup_banner->image)
        <div class="">
          <img class="py-1" src="{{ asset('storage/media/'.$popup_banner->image) }}" alt="popup_banner banner">
        </div>
        @else
        <div class="">
          <i class="fas fa-bell fa-4x animated rotateIn mb-4" aria-hidden="true"></i>
        </div>
        @endif
        <div class="">
          {{ $popup_banner->description ?? '' }}
        </div>
      </div>
    </div>
  </div>
</div>
@endif
