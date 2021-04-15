@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
<div class="container-fluid">
	<h3>Add Damaged Good</h3>
        <form action="/damage-sale/create" method="post">
			@csrf
				<div class="form-group">
					<label>Select Product</label>
					<select id="product_selector" name="product_id" class="form-control selectpicker">
						@foreach($allProducts as $key => $value)
						
						
							@if($value->is_variant == 1)
								@foreach($value->variant as $v)
									<option data-variant-id="{{$v->pivot->variant_id}}" value="{{$value->id}}">{{$value->name.'-'.$v->pivot->variant_name}}</option>
								@endforeach
							@else
							<option data-variant-id="0" value="{{$value->id}}">{{$value->name}}</option>
							@endif
							
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label>Quantity</label>
					<input type="number" name="qty" class="form-control" >
					<input type="hidden" name="variant_id" id="variant_id">
					<input type="hidden" name="_method" value="put">
				</div>
				
				<div class="form-group">
					<label>Note</label>
					<textarea  name="note" class="form-control"></textarea>
				</div>

				<button type="submit" name="update_btn" class="btn btn-primary">Save</button>
		</form>
	</div>
</section>

<script>
jQuery(document).on('change','#product_selector',function(){
	jQuery('#variant_id').val(jQuery(this).find('option:selected').attr('data-variant-id'));
});

</script>

@endsection('content')