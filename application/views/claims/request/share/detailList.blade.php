<div class="row-fluid" >
  <div class="span12">
    <div id="dataList" class="rows-fluid show-grid">
      {{ $detailList }}
    </div>
  </div>
</div>

<!-- Modal -->

<div id="addResitModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Uploaded Receipt</h3>
</div>
<div class="modal-body">
<div id="recCoru" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
    <div class="item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
    <div class="item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#recCoru" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#recCoru" data-slide="next">&rsaquo;</a>
</div>
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>