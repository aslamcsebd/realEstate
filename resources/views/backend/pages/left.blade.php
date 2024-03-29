@extends('backend.master')
@section('title') 
   Left side
@endsection

@section('content')
   @include('common.alertMessage')
   <div class="content-wrapper p-3">
      <div class="btn-group mb-2" role="group" aria-label="Basic example"> 
         <button class="btn btn-sm btn-info text-light" data-toggle="modal" data-original-title="test" data-target="#addSocialSite">Add Social Side</button>
      </div>

      <div class="card border border-danger">
         <div class="card-body p-1">
            <p class="bg-info text-center pb-1">Social site [{{$SocialSite->count()}}]</p>
            <table class="table table-bordered table-striped table-hover">
               <thead class="text-center">
                  <th>No</th>                           
                  <th>Logo</th>
                  <th>Social name</th>
                  <th>Link</th>
                  <th>Order By</th>
                  <th>Status</th>
                  <th>Action</th>
               </thead>
               <tbody>
                  @foreach($SocialSite as $item)
                     <tr>
                        <td width="7%">{{$loop->iteration}}</td>
                        <td>
                           <a href='{{ url($item->socialUrl) }}' target="_blank">{!! $item->socialLogo !!}</a>
                        </td>
                        <td>
                           <a class="capitalize" href='{{ url($item->socialUrl) }}' target="_blank">{!! $item->socialName !!}</a>
                        </td>
                        <td>
                           <a href='{{ url($item->socialUrl) }}' target="_blank">{{ $item->socialUrl }}</a>
                        </td>
                        <td width="8%">
                           <div class="btn-group">
                              <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                 <i class="far fa-check-circle"></i>
                                 {{$item->orderBy}}
                              </button>
                              <div class="dropdown-menu">
                                 @for($i=1; $i <= $SocialSite->count(); $i++)                                          
                                    <a href="{{ url('orderBy', ['social_sites', $item->id, $i, 'socialSite'])}}"
                                       class="{{$i==$item->orderBy ? 'bg-info text-white disabled pl-2' : 'text-center'}} dropdown-item">
                                       @if($i==$item->orderBy)
                                          <i class="far fa-check-circle"></i>
                                       @endif
                                       {{$i}}
                                    </a>
                                 @endfor
                              </div>
                           </div>
                        </td>
                        <td width="8%">
                           @if($item->status == 1)
                              <a href="{{ url('itemStatus', [$item->id, 'social_sites', 'socialSite'])}}" class="btn px-1 btn-sm btn-success" title="Click for inactive">Active</a>
                           @else
                              <a href="{{ url('itemStatus', [$item->id, 'social_sites', 'socialSite'])}}" class="btn px-1 btn-sm btn-danger" title="Click for active">Inactive</a>
                           @endif
                        </td>
                        <td width="15%">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <a class="btn btn-sm btn-success text-light" data-toggle="modal" data-target="#editSocialSite" data-id="{{$item->id}}" data-name="{{$item->socialName}}" data-url="{{$item->socialUrl}}" data-tab="socialSite">Edit</a>
                              
                              <a class="btn btn-sm btn-danger text-light" href="{{ url('itemDelete', [$item->id, 'social_sites', 'socialSite'])}}" onclick="return confirm('Are you want to delete this?')">Delete</a>
                           </div>
                        </td>
                     </tr> 
                  @endforeach                                        
               </tbody>
            </table>
         </div>            
      </div>
   </div>
@endsection

@section('js')

   {{-- Add social site --}}
      <div class="modal fade" id="addSocialSite" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title text-center" id="exampleModalLabel">Add social site</h6>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body">
                  <form action="{{ url('addSocialSite') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                     @csrf
                     <div class="form row">
                        <div class="form-group col-5">
                           <label for="socialName">Social Media Name :</label>
                           <input name="socialName" class="form-control" id="socialName" type="text" placeholder="Ex: Facebook, Youtube etc" required>
                        </div>
                        <div class="form-group col">
                           <label for="socialLogo">Social Logo :</label>
                           <input type="text" name="socialLogo" id="socialLogo" value="<i class='fab fa-name'></i>" class="form-control mb-2" placeholder="<i class='fa fa-name'></i>" required>
                        </div>
                     </div>                
                     <div class="form">
                        <div class="form-group">
                           <label for="socialUrl" class="mb-2">Social site URL :</label>
                           <input type="text" id="socialUrl" class="form-control" name="socialUrl" placeholder="Example : www.facebook.com/userName" required>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <div class="btn-group">
                           <button class="btn btn-sm btn-primary">Save</button>
                           <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

   {{-- Edit social site --}}
      <div class="modal fade" id="editSocialSite" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title text-center" id="exampleModalLabel">Edit social site</h6>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body">
                  <form action="{{ url('editSocialSite') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                     @csrf                   
                     <div class="form">
                        <input name="id" id="id" hidden>
                        <input name="tab" id="tab" hidden>
                        <div class="form-group">
                           <label for="socialName" class="mb-2">Social site name :</label>
                           <input type="text" id="socialName" class="form-control" name="socialName" placeholder="Example : Facebook, Instagram..." required>
                        </div>
                        <div class="form-group">
                           <label for="socialUrl" class="mb-2">Social site URL :</label>
                           <input type="text" id="socialUrl" class="form-control" name="socialUrl" placeholder="Example : www.facebook.com/userName" required>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <div class="btn-group">
                           <button class="btn btn-sm btn-primary">Save</button>
                           <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <script type="text/javascript">
         $('#editSocialSite').on('show.bs.modal', function (event) {
            console.log('Model Opened')
            var button = $(event.relatedTarget)

            var id = button.data('id')
            var socialName = button.data('name')
            var socialUrl = button.data('url')
            var tab = button.data('tab') 
            
            var modal = $(this)
            
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #socialName').val(socialName);
            modal.find('.modal-body #socialUrl').val(socialUrl);
            modal.find('.modal-body #tab').val(tab);
         })
      </script>

@endsection